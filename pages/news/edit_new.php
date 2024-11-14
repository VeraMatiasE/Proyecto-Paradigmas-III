<?php
require_once "../../include/config/session.php";

require_once '../../include/functions/role.php';
if (!(userHasRole("news") || userHasRole("admin"))) {
    http_response_code(500);
    exit;
}
if (!isset($_GET['slug'])) {
    http_response_code(404);
    exit;
}
$slug = $_GET['slug'];

require '../../include/config/database.php';
require '../../include/functions/news_info.php';
$pdo = getDatabaseConnection();
$new_info = getNewsInfo($pdo, $slug);

$title = "Editar ";
$relative_path_scripts = "../../..";
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
        <input type="text" name="title" value="<?= htmlspecialchars($new_info['title'], ENT_QUOTES, 'UTF-8') ?>">
        <br>
        <label for="banner">Imagen de Banner</label>
        <img src="../../../images/News/uploads/<?= htmlspecialchars($new_info['banner'], ENT_QUOTES, "UTF-8") ?>"
            class="banner-image" />
        <input type="file" name="banner" id="banner" accept="image/*">
        <br>
        <?php
        require_once "../../include/functions/news_html.php";
        $json_content = json_decode($new_info['content'], true);
        $html_content = jsonToHtml($json_content, '../../../images/News/uploads');
        ?>
        <rich-editor></rich-editor>
        <button type="submit" class="button-background">Enviar</button>
        <input type="hidden" id="new-id" value="<?= $new_info['id_new'] ?>">
    </form>

    <script>
        window.addEventListener('load', function () {
            const contentFromDB = `<?= addslashes($html_content) ?>`;
            const editor = document.querySelector('rich-editor');
            editor.setContent(contentFromDB);
        });
    </script>
</body>

<?php
include_once "../../include/footer.php";
?>