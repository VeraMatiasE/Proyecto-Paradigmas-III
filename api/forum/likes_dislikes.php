<?php
session_start();

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id_comment'], $data['like_type']) && isset($_SESSION['id_user'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Datos invalidos.']);
    exit();
}

require '../../include/config/database.php';
$pdo = getDatabaseConnection();

$id_comment = $data['id_comment'];
$likeType = $data['like_type'];
$id_user = $_SESSION['id_user'];

try {
    // Verificar si el usuario ya reaccionó
    $sql = "SELECT like_type FROM comment_likes WHERE id_comment = :id_comment AND id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
    $stmt->bindParam(":id_comment", $id_comment, PDO::PARAM_INT);
    $stmt->execute();
    $existingReaction = $stmt->fetch();


    if ($existingReaction) {
        if ($existingReaction['like_type'] === $likeType) {
            $stmt = $pdo->prepare("DELETE FROM comment_likes WHERE id_comment = :id_comment AND id_user = :id_user");
            $stmt->execute(['id_comment' => $id_comment, 'id_user' => $id_user]);
            $likeType = null;
        } else {
            $stmt = $pdo->prepare("UPDATE comment_likes SET like_type = :like_type WHERE id_comment = :id_comment AND id_user = :id_user");
            $stmt->bindParam(":id_comment", $id_comment, PDO::PARAM_INT);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindParam(":like_type", $likeType, PDO::PARAM_STR);
            $stmt->execute();
        }
    } else {
        $stmt = $pdo->prepare("INSERT INTO comment_likes (id_comment, id_user, like_type) VALUES (:id_comment, :id_user, :like_type)");
        $stmt->bindParam(":id_comment", $id_comment, PDO::PARAM_INT);
        $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->bindParam(":like_type", $likeType, PDO::PARAM_STR);
        $stmt->execute();
    }

    $sql = "SELECT like_count, dislike_count FROM comments WHERE id_comment = :id_comment";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_comment' => $id_comment]);
    $totals = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'likes' => $totals['like_count'],
        'dislikes' => $totals['dislike_count'],
        'userReaction' => $likeType
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error al actualizar los likes y dislikes.']);
}

?>