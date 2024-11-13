<?php
require_once "../../include/config/session.php";
if (!isset($_SESSION['id_user'])) {
    header("Location: login/sigin.php");
    exit;
}

$title = "Mis Noticias";
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
        <h1>Mis Noticias</h1>
        <div class="news-list">
            <a href="create_new.php" class="button button-background">+ Escribir Noticia</a>

            <?php
            $id_user = $_SESSION['id_user'];
            require_once "../../include/config/database.php";
            $pdo = getDatabaseConnection();
            $sql = "SELECT title, slug, published_at FROM news 
                    WHERE id_author = :id_user";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);
            $stmt->execute();
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($news as $new) {
                ?>
                <div class="news-item">
                    <h2><a href="<?= $new['slug'] ?>"><?= $new['title'] ?></a></h2>
                    <p><?= $post['published_at'] ?></p>
                    <a href="../edit_new/<?= $new['slug'] ?>" class="button edit">Editar</a>
                    <a href="delete_new/<?= $new['slug'] ?>" class="button delete">Eliminar</a>
                </div>
                <?php
            }
            ?>
        </div>
    </main>
    <?php
    include_once "../../include/footer.php";
    ?>