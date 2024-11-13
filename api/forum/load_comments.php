<?php
session_start();
include '../../include/config/database.php';

require '../../include/functions/comments.php';

if (!isset($_GET['slug']) && !isset($_GET['offset'])) {
    echo json_encode(['success' => false, 'error' => 'Parámetros faltantes.']);
    exit;
}

$slug = $_GET['slug'];
$offset = $_GET['offset'];
$id_user = $_SESSION['id_user'] ?? null;

$pdo = getDatabaseConnection();
try {
    $id_post = getIdFromSlug($pdo, $slug);
    $comments = getMainComments($pdo, $id_post, $offset, 5, $id_user);
    foreach ($comments as &$comment) {
        $comment['replies'] = getRepliesWithLimit($pdo, $comment['id_comment'], 1, 3, $id_user);
    }
    unset($comment);

    echo json_encode([
        'success' => true,
        'comments' => $comments,
        'is_logged' => $id_user != null
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error al cargar comentarios']);
}
?>