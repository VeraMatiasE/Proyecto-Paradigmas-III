<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    http_response_code(500);
    exit;
}
$id_user = $_SESSION["id_user"];
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['slug'])) {
    require_once '../../include/config/database.php';
    $pdo = getDatabaseConnection();
    $slug = $_GET['slug'];
    $stmt = $pdo->prepare("SELECT EXISTS (SELECT 1 FROM posts WHERE slug = :slug AND id_user = :id_user)");
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    $existPost = $stmt->fetchColumn();

    if ($existPost) {
        $stmt = $pdo->prepare("UPDATE posts SET is_deleted = True WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'message' => 'Post eliminado con éxito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'El post no existe']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Solicitud no válida']);
}
?>