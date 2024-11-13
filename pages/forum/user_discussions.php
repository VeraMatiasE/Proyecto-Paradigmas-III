<?php
require_once "../../include/config/session.php";
if (!isset($_SESSION['id_user'])) {
    header("Location: login/sigin.php");
    exit;
}

$title = "Mis Publicaciones en el Foro";
$styles = "forum-new-list.css";
$scripts = ["color-switch.js", "hamburger-menu.js"];


include_once "../../include/head.php";
require_once "../../include/config/database.php";
$pdo = getDatabaseConnection();
?>

<body>
    <?php
    include_once "../../include/header.php";
    ?>

    <main>
        <h1>Mis Publicaciones en el Foro</h1>
        <div class="forum-list">
            <a href="create_post.php" class="button button-background">+ Crear Post</a>

            <?php
            $id_user = $_SESSION['id_user'];
            require_once "../../include/config/database.php";
            $pdo = getDatabaseConnection();
            $sql = "SELECT title, slug, count_comments FROM posts 
                    WHERE id_user = :id_user AND is_deleted IS FALSE";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($posts as $post) {
                ?>
                <div class="forum-post">
                    <h2><a href="<?= $post['slug'] ?>"><?= $post['title'] ?></a></h2>
                    <p><?= $post['count_comments'] ?> comentarios</p>
                    <a href="edit_post/<?= $post['slug'] ?>" class="button edit">Editar</a>
                    <a href="delete_post/<?= $post['slug'] ?>" class="button delete">Eliminar</a>
                </div>
                <?php
            }
            ?>

        </div>
    </main>
    <?php
    include_once "../../include/footer.php";
    ?>