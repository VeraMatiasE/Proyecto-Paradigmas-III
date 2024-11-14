<?php
session_start();
require_once '../../include/functions/role.php';
if (!isset($_SESSION["id_user"])) {
    http_response_code(500);
    exit;
}

$hasAdminRole = userHasRole("admin");
$id_user = $_SESSION["id_user"];

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['slug'])) {
    require_once '../../include/config/database.php';
    $pdo = getDatabaseConnection();
    $slug = $_GET['slug'];

    $sql = "SELECT EXISTS (SELECT 1 FROM news WHERE slug = :slug";
    if (!$hasAdminRole) {
        $sql .= " AND id_author = :id_user";
    }
    $sql .= ")";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    if (!$hasAdminRole) {
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    }
    $stmt->execute();
    $existsNew = $stmt->fetchColumn();

    if ($existsNew) {
        $stmt = $pdo->prepare("UPDATE news SET is_deleted = True WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'message' => 'Noticia eliminada con éxito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'La noticia no existe']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Solicitud no válida']);
}
?>