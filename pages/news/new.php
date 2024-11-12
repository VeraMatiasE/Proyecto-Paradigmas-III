<?php
if (!isset($_GET['slug'])) {
  header("Location: /pages/errors/404.php");
  exit();
}

$slug = $_GET['slug'];

require '../../include/config/database.php';

$sql = "SELECT id_new, u.firstname, u.lastname, title, banner, content, published_at FROM news AS n
          LEFT JOIN users AS u ON u.id_user = n.id_author
          WHERE slug = :slug";

$pdo = getDatabaseConnection();
$stmt = $pdo->prepare($sql);
$stmt->execute(["slug" => $slug]);
$new_info = $stmt->fetch(PDO::FETCH_ASSOC);

$title = "Noticia: " . htmlspecialchars($post_info["title"], ENT_QUOTES, 'UTF-8');

$scripts = ["color-switch.js", "hamburger-menu.js"];

$styles = "new.css";
include_once "../../include/head.php";

?>

<body>
  <?php
  include_once "../../include/header.php";
  ?>

  <div class="news-article">
    <img src="../../images/News/uploads/<?= htmlspecialchars($new_info['banner'], ENT_QUOTES, "UTF-8") ?>"
      class="banner-image" />
    <div class="news-content">
      <h1><?= htmlspecialchars($new_info['title'], ENT_QUOTES, "UTF-8") ?></h1>
      <p class="news-meta"><?= htmlspecialchars($new_info['published_at'], ENT_QUOTES, "UTF-8") ?></p>
      <p class="news-text">
        <?php
        require_once "../../include/functions/news_html.php";
        $json_content = json_decode($new_info['content'], true);
        echo jsonToHtml($json_content);
        ?>
      </p>
    </div>
  </div>

  <?php
  include_once "../../include/footer.php";
  ?>