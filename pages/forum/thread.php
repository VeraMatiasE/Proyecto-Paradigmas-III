<?php
session_start();
$id_user = $_SESSION["id_user"];

if (!isset($_GET['id_comment']) || !isset($_GET['slug'])) {
    header("Location: /pages/errors/404.php");
    exit();
}

$id_comment = filter_input(INPUT_GET, 'id_comment', FILTER_VALIDATE_INT);
$slug = $_GET['slug'];

require '../../include/config/database.php';
require '../../include/functions/comments.php';

$pdo = getDatabaseConnection();

const MAX_COMMENTS = 7;
const MAX_DEPTH = 4;

$sql = "SELECT id_comment, id_reply, like_count, dislike_count, u.username, content
        FROM comments AS c
        LEFT JOIN users AS u ON u.id_user = c.id_user
        WHERE id_comment = :id_comment";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
$stmt->execute();
$mainComment = $stmt->fetch(PDO::FETCH_ASSOC);

$title = "Hilo Completo";

$baseScripts = ["forum/response.js", "forum/load_replies.js", "color-switch.js", "hamburger-menu.js"];

$additionalScripts = isset($_SESSION['id_user']) ? ["forum/likes_dislikes.js"] : [];

$scripts = array_merge($baseScripts, $additionalScripts);

$moduleScripts = ["forum/load_replies.js", "forum/likes_dislikes.js", "forum/response.js"];
$styles = "discussion.css";
include_once "../../include/head.php";
?>

<body>
    <?php include_once "../../include/header.php"; ?>

    <main>
        <section class="responses">
            <h3>Hilo Completo</h3>
            <a class="back" href="/pages/forum/discussion/<?= htmlspecialchars($slug) ?>">«Volver a la discusión principal»</a>
            <?php
            if (!empty($mainComment)) {
                $mainComment['replies'] = getRepliesWithLimit($pdo, $mainComment['id_comment'], 1, MAX_COMMENTS, $id_user);
                renderComments([$mainComment], MAX_DEPTH);
            } else {
                echo "<p>No hay comentarios en este hilo.</p>";
            }
            ?>
        </section>
    </main>

    <?php include_once "../../include/footer.php"; ?>
</body>

</html>