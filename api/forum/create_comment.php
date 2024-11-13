<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    http_response_code(500);
    exit;
}

require_once '../../include/config/database.php';
require_once '../../include/functions/comments.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['content']) || !isset($data['slug'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Datos incompletos.']);
        exit;
    }

    $content = trim($data['content']);
    $id_comment = $data['id_comment'];
    if ($id_comment !== null)
        $id_comment = intval($data['id_comment']);
    $id_user = $_SESSION["id_user"];
    $slug = $data['slug'];

    $pdo = getDatabaseConnection();
    
    $id_post = getIdFromSlug($pdo, $slug);

    $sql = "INSERT INTO comments (content, id_user, id_reply, id_post, created_at) 
                VALUES (:content, :id_user, :id_reply, :id_post, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'content' => $content,
        'id_reply' => $id_comment,
        'id_user' => $id_user,
        'id_post' => $id_post,
    ]);

    $newCommentId = $pdo->lastInsertId();

    $response = [
        'id_comment' => $newCommentId,
        'content' => htmlspecialchars($content, ENT_QUOTES, 'UTF-8'),
        'created_at' => getFormattedDate(date('Y-m-d H:i:s')),
        'user_reaction' => '',
        'like_count' => 0,
        'dislike_count' => 0,
        'username' => $_SESSION['username'],
    ];
    
    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error al crear el comentario']);
}
?>