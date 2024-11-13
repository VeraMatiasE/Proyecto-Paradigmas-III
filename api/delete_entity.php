<?php
require_once "../include/config/session.php";
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: login/sigin.php");
    exit;
}

require_once "../include/config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['type'])) {
    $entityId = $data['id'];
    $entityType = $data['type'];

    $entityIdColumns = [
        'mission' => 'id_mission',
        'news' => 'id_new',
        'users' => 'id_user',
        'space_agency' => 'id_agency',
        'celestial_object' => 'id_celestial_object',
        'mission_type' => 'id_mission_type'
    ];

    if (!array_key_exists($entityType, $entityIdColumns)) {
        echo json_encode(["success" => false, "message" => "Tipo de entidad no válido."]);
        exit;
    }

    $idColumn = $entityIdColumns[$entityType];

    try {
        $pdo = getDatabaseConnection();

        $sql = "UPDATE $entityType SET is_deleted = 1 WHERE $idColumn = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $entityId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontró la entidad o ya estaba eliminada."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error de base de datos: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID o tipo de entidad no proporcionado."]);
}
?>