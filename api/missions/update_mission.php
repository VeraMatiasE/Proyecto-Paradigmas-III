<?php
require_once "../../include/config/session.php";
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "No tienes permisos para realizar esta acción."]);
    exit;
}

require_once "../../include/config/database.php";
$pdo = getDatabaseConnection();

try {
    $id_mission = $_POST['id_mission'] ?? null;
    $name = $_POST['name'] ?? null;
    $launchDate = $_POST['launch_date'] ?? null;
    $description = $_POST['description'] ?? null;
    $launch_site = $_POST['launch_site'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $rocket_type = $_POST['rocket_type'] ?? null;
    $mission_duration = $_POST['mission_duration'] ?? null;
    $crew_size = $_POST['crew_size'] ?? null;
    $budget = $_POST['budget'] ?? null;
    $objectives = $_POST['objectives'] ?? null;
    $achievements = $_POST['achievements'] ?? null;

    require_once "../../include/functions/slug.php";
    $slug = null;

    if ($name != null) {
        $slug = generateUniqueSlug($name, $pdo, 'mission', 'slug', 5);
    } else {
        $sql = "SELECT slug FROM mission WHERE id_mission = :id_mission";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_mission', $id_mission, PDO::PARAM_INT);
        $stmt->execute();
        $slug = $stmt->fetchColumn();
    }
    require_once "../../include/functions/post_info.php";
    $id_status = getIdByName($pdo, 'status', $_POST['status'], 'id_status');
    $id_agency = getIdByName($pdo, 'space_agency', $_POST['agency'], 'id_agency');
    $id_celestial_object = getIdByName($pdo, 'celestial_object', $_POST['celestial_object'], 'id_celestial_object');
    $id_mission_type = getIdByName($pdo, 'mission_type', $_POST['mission_type'], 'id_mission_type');

    if (!$id_mission) {
        throw new Exception("Faltan datos necesarios para actualizar la misión.");
    }

    $bannerPath = null;
    $banner = null;
    if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
        $bannerTempPath = $_FILES['banner']['tmp_name'];
        $banner = "$slug.webp";
        $bannerPath = "../../images/Missions/Banners/$banner.webp";

        $imagick = new Imagick($bannerTempPath);
        $imagick->resizeImage(800, 474, Imagick::FILTER_LANCZOS, 1);
        $imagick->setImageFormat("webp");
        $imagick->writeImage($bannerPath);
        $imagick->clear();
        $imagick->destroy();

    }

    $sql = "SELECT id_mission_details FROM mission WHERE id_mission = :id_mission";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_mission', $id_mission, PDO::PARAM_INT);
    $stmt->execute();
    $id_mission_details = $stmt->fetchColumn();

    $sql = "UPDATE mission SET name = :name, slug = :slug, launch_date = :launch_date, description = :description,
            id_status = :id_status, id_celestial_object = :id_celestial_object, id_mission_type = :id_mission_type, id_agency = :id_agency";
    if ($bannerPath) {
        $sql .= ", banner = :banner";
    }
    $sql .= " WHERE id_mission = :id_mission";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':launch_date', $launchDate);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id_status', $id_status, PDO::PARAM_INT);
    $stmt->bindParam(':id_celestial_object', $id_celestial_object, PDO::PARAM_INT);
    $stmt->bindParam(':id_mission_type', $id_mission_type, PDO::PARAM_INT);
    $stmt->bindParam(':id_agency', $id_agency, PDO::PARAM_INT);
    $stmt->bindParam(':id_mission', $id_mission, PDO::PARAM_INT);

    if ($bannerPath) {
        $stmt->bindParam(':banner', $bannerPath);
    }

    $stmt->execute();

    $sql = "UPDATE mission_details SET launch_site = :launch_site, end_date = :end_date, rocket_type = :rocket_type,
            mission_duration = :mission_duration, crew_size = :crew_size, budget = :budget, objectives = :objectives, achievements = :achievements
            WHERE id_mission_details = :id_mission_details";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':launch_site', $launch_site);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':rocket_type', $rocket_type);
    $stmt->bindParam(':mission_duration', $mission_duration);
    $stmt->bindParam(':crew_size', $crew_size, PDO::PARAM_INT);
    $stmt->bindParam(':budget', $budget);
    $stmt->bindParam(':objectives', $objectives);
    $stmt->bindParam(':achievements', $achievements);
    $stmt->bindParam(':id_mission_details', $id_mission_details, PDO::PARAM_INT);
    $stmt->execute();


    echo json_encode(["success" => "Misión actualizada exitosamente.", "slug" => $slug]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en el servidor" . $e->getMessage()]);
}


?>