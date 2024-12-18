<?php
if (!isset($_GET['slug'])) {
  header("Location: /pages/errors/404.php");
  exit();
}

$slug = $_GET['slug'];

require '../../include/config/database.php';

$sql = "SELECT id_new, u.firstname, u.lastname, title, banner, content, published_at FROM news AS n
          LEFT JOIN users AS u ON u.id_user = n.id_author
          WHERE slug = :slug AND n.is_deleted IS FALSE";

$pdo = getDatabaseConnection();
$stmt = $pdo->prepare($sql);
$stmt->execute(["slug" => $slug]);
$new_info = $stmt->fetch(PDO::FETCH_ASSOC);

$title = "Noticia: " . htmlspecialchars($new_info["title"], ENT_QUOTES, 'UTF-8');

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
      <div class="news-meta">
        <span class="author">
          <?= htmlspecialchars($new_info['firstname'], ENT_QUOTES, "UTF-8") ?>
          <?= htmlspecialchars($new_info['lastname'], ENT_QUOTES, "UTF-8") ?>
        </span>
        <span class="separator">|</span>
        <span class="date">
          <?= htmlspecialchars($new_info['published_at'], ENT_QUOTES, "UTF-8") ?>
        </span>
      </div>
      <p class="news-text">
        <?php
        require_once "../../include/functions/news_html.php";
        $json_content = json_decode($new_info['content'], true);
        echo jsonToHtml($json_content, '../../images/News/uploads/');
        ?>
      </p>
    </div>
  </div>

  <?php
  include_once "../../include/footer.php";
  ?>