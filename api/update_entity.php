<?php
session_start();
require_once "../include/config/database.php";
header("Content-Type: application/json");
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$pdo = getDatabaseConnection();

$table = $_POST['table'] ?? '';
$id_column = $_POST['id_column'] ?? '';
$id_value = $_POST['id_value'] ?? 0;
$fields = $_POST;

if (!$table || !$id_column || !$id_value || empty($fields)) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$columns = [];
$values = [];
$params = [];

$uploadDir = '';
switch ($table) {
    case 'celestial_object':
        $uploadDir = '../images/Missions/Logos/';
        break;
    case 'space_agency':
        $uploadDir = '../images/SpaceAgencies/';
        break;
    case 'mission_type':
        $uploadDir = '../images/Missions/Icons/';
        break;
    default:
        echo json_encode(["success" => false, "message" => "Tabla no soportada para carga de archivos"]);
        exit;
}

$logo = null;
if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['logo']['tmp_name'];
    $fileName = $_FILES['logo']['name'];
    $fileSize = $_FILES['logo']['size'];
    $fileType = $_FILES['logo']['type'];

    $allowedTypes = ['image/svg', 'image/svg+xml'];
    if (in_array($fileType, $allowedTypes)) {
        $newFileName = uniqid('logo_') . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        $destPath = $uploadDir . $newFileName;

        if (!is_writable($uploadDir)) {
            echo json_encode(["success" => false, "message" => "La carpeta $uploadDir no tiene permisos de escritura."]);
            exit;
        }

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $logo = $newFileName;
        } else {
            echo json_encode(["success" => false, "message" => "Error al cargar el logo"]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "Tipo de archivo no permitido"]);
        exit;
    }
}

if ($logo) {
    $fields['logo'] = $logo;
}

foreach ($fields as $field => $value) {
    if ($field != 'table' && $field != 'id_column' && $field != 'id_value') {
        $columns[] = "$field = ?";
        $values[] = $value;
    }
}
$values[] = $id_value;

$sql = "UPDATE $table SET " . implode(", ", $columns) . " WHERE $id_column = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute($values)) {
    echo json_encode(["success" => true, "message" => "Registro actualizado exitosamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar el registro"]);
}
?>