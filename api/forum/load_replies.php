<?php
include '../../include/config/database.php';
session_start();
require_once '../../include/functions/comments.php';

if (!isset($_GET['comment_id']) || !isset($_GET['depth_limit'])) {
    echo json_encode(['success' => false, 'error' => 'Parámetros faltantes.']);
    exit;
}

$id_comment = (int) $_GET['comment_id'];
$depthLimit = (int) $_GET['depth_limit'];
$pdo = getDatabaseConnection();
$id_user = $_SESSION['id_user'] ?? null;

try {
    $replies = getRepliesWithLimit($pdo, $id_comment, 4, $depthLimit, $id_user);

    $hasMoreReplies = count($replies) >= $depthLimit;

    echo json_encode([
        'success' => true,
        'replies' => $replies,
        'hasMoreReplies' => $hasMoreReplies,
        'is_logged' => $id_user != null
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error al cargar respuestas']);
}

?>