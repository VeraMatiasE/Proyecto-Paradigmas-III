<?php
require_once "../../include/config/session.php";
require_once '../../include/functions/role.php';

if (!(userHasRole("news") || userHasRole("admin"))) {
    http_response_code(404);
    exit;
}

$title = "Escribir una Noticia";
$scripts = ["color-switch.js", "hamburger-menu.js", "news/rich_text_editor.js", "news/submit_new.js"];

$styles = "modifyNew.css";
include_once "../../include/head.php";
?>

<body>
    <?php
    include_once "../../include/header.php";
    ?>
    <form class="news-form">
        <label for="title">Título</label>
        <input type="text" name="title">
        <br>
        <label for="banner">Imagen de Banner</label>
        <input type="file" name="banner" id="banner" accept="image/*" required>
        <br>
        <rich-editor></rich-editor>
        <button type="submit" class="button-background">Enviar</button>
    </form>
</body>

<?php
include_once "../../include/footer.php";
?>