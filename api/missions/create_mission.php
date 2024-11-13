<?php
require_once "../../include/config/session.php";
require_once "../../include/config/database.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "No tienes permisos para realizar esta acción."]);
    exit;
}

$requiredFields = ['name', 'launch_date', 'status', 'agency', 'celestial_object', 'mission_type'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta el campo obligatorio: $field"]);
        exit;
    }
}

try {
    $pdo = getDatabaseConnection();

    require_once "../../include/functions/post_info.php";
    $id_status = getIdByName($pdo, 'status', $_POST['status'], 'id_status');
    $id_agency = getIdByName($pdo, 'space_agency', $_POST['agency'], 'id_agency');
    $id_celestial_object = getIdByName($pdo, 'celestial_object', $_POST['celestial_object'], 'id_celestial_object');
    $id_mission_type = getIdByName($pdo, 'mission_type', $_POST['mission_type'], 'id_mission_type');

    if (!$id_status || !$id_agency || !$id_celestial_object || !$id_mission_type) {
        http_response_code(400);
        echo json_encode(["error" => "Datos inválidos proporcionados."]);
        exit;
    }

    require_once "../../include/functions/slug.php";
    $slug = generateUniqueSlug($_POST['name'], $pdo, 'mission', 'slug', 5);

    if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
        $bannerFile = $_FILES['banner'];
        $destinationPath = "../../images/Missions/Banners/$slug.webp";

        $image = new Imagick($bannerFile['tmp_name']);
        $image->resizeImage(800, 474, Imagick::FILTER_LANCZOS, 1);
        $image->setImageFormat("webp");
        $image->writeImage($destinationPath);

        $image->clear();
        $image->destroy();

        $_POST['banner'] = "{$slug}.webp";
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Error al subir la imagen."]);
        exit;
    }

    $sqlDetails = "INSERT INTO mission_details (launch_site, end_date, rocket_type, mission_duration, crew_size, budget, objectives, achievements)
                   VALUES (:launch_site, :end_date, :rocket_type, :mission_duration, :crew_size, :budget, :objectives, :achievements)";
    $stmtDetails = $pdo->prepare($sqlDetails);

    $stmtDetails->execute([
        ':launch_site' => $_POST['launch_site'] ?? null,
        ':end_date' => $_POST['end_date'] ?? null,
        ':rocket_type' => $_POST['rocket_type'] ?? null,
        ':mission_duration' => $_POST['mission_duration'] ?? null,
        ':crew_size' => $_POST['crew_size'] ?? null,
        ':budget' => $_POST['budget'] ?? null,
        ':objectives' => $_POST['objectives'] ?? null,
        ':achievements' => $_POST['achievements'] ?? null
    ]);

    $id_mission_details = $pdo->lastInsertId();

    $sql = "INSERT INTO mission (name, slug, launch_date, banner, description, id_status, id_agency, id_celestial_object, id_mission_type, id_mission_details)
            VALUES (:name, :slug, :launch_date, :banner, :description, :id_status, :id_agency, :id_celestial_object, :id_mission_type, :id_mission_details)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name", $_POST['name']);
    $stmt->bindParam(":slug", $slug);
    $stmt->bindParam(":launch_date", $_POST['launch_date']);
    $stmt->bindParam(":banner", $_POST['banner']);
    $stmt->bindParam(":description", $_POST['description']);
    $stmt->bindParam(":id_status", $id_status, PDO::PARAM_INT);
    $stmt->bindParam(":id_agency", $id_agency, PDO::PARAM_INT);
    $stmt->bindParam(":id_celestial_object", $id_celestial_object, PDO::PARAM_INT);
    $stmt->bindParam(":id_mission_type", $id_mission_type, PDO::PARAM_INT);
    $stmt->bindParam(":id_mission_details", $id_mission_details, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(["success" => "La misión fue creada con éxito.", "slug" => $slug]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en el servidor"]);
}
?>