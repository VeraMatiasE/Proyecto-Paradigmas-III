<?php
require_once "../../include/config/session.php";
if (!isset($_SESSION['id_user']) && $_SESSION['role'] !== "admin") {
    header("Location: login/sigin.php");
    exit;
}

require_once "../../include/config/database.php";

$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['id_mission'])) {
    $id_mission = $data['id_mission'];

    try {
        $pdo = getDatabaseConnection();

        $sql = "UPDATE mission SET is_deleted = 1 WHERE id_mission = :id_mission";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_mission', $id_mission, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontró la misión o ya estaba eliminada."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error de base de datos: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID de misión no proporcionado."]);
}
?>