<?php
$title = "Noticias Espaciales";

$scripts = ["color-switch.js", "hamburger-menu.js", "missions/loading-image.js"];

$styles = "news.css";
include_once "../include/head.php";
?>

<body>
  <?php
  include_once "../include/header.php";
  ?>

  <section class="main-news">
    <?php
    require_once '../include/config/database.php';

    try {
      $pdo = getDatabaseConnection();

      // Obtener la noticia principal y las secundarias en una sola consulta
      $sql = '
          SELECT title, banner, slug, 
                 CASE 
                    WHEN rn = 1 THEN "main" 
                    ELSE "secondary" 
                 END AS news_type
          FROM (
              SELECT title, banner, slug, is_deleted, ROW_NUMBER() OVER (ORDER BY published_at DESC) AS rn
              FROM news
          ) AS subquery
          WHERE rn <= 4 AND is_deleted IS FALSE
          ORDER BY rn
        ';

      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $newsItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      header("Location: /pages/errors/500.php");
      exit;
    }
    ?>
    <?php if (!empty($newsItems)): ?>
      <div class="main-article">
        <?php
        $mainNews = array_filter($newsItems, fn($item) => $item['news_type'] === 'main');
        $mainNews = reset($mainNews);
        ?>
        <a href="news/<?= htmlspecialchars($mainNews['slug'], ENT_QUOTES, "UTF-8") ?>">
          <div class="image-container">
            <div class="skeleton"></div>
            <img src="<?= htmlspecialchars($mainNews['banner'], ENT_QUOTES, "UTF-8") ?>" alt="Imagen Principal"
              class="lazy-load" />
          </div>
          <div class="main-article-content">
            <h2>
              <?= htmlspecialchars($mainNews['title'], ENT_QUOTES, "UTF-8") ?>
            </h2>
          </div>
        </a>
      </div>
    <?php endif ?>
    <div class="secondary-articles">
      <?php
      $secondaryNews = array_filter($newsItems, fn($item) => $item['news_type'] === 'secondary');
      ?>
      <?php foreach ($secondaryNews as $new): ?>
        <article>
          <a href="news/<?= htmlspecialchars($new['slug'], ENT_QUOTES, "UTF-8") ?>">
            <div class="image-container">
              <div class="skeleton"></div>
              <img src="/images/News/uploads/<?= htmlspecialchars($new['banner'], ENT_QUOTES, "UTF-8") ?>"
                alt="Imagen Misión" class="lazy-load" />
            </div>
            <h3>
              <?= htmlspecialchars($new['title'], ENT_QUOTES, "UTF-8") ?>
            </h3>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section>
    <div class="news-header">
      <h2>Últimas Noticias</h2>
      <hr />
    </div>
    <div class="news-grid">

      <?php

      $sql = 'SELECT title, banner, slug
              FROM news AS n
              WHERE is_deleted IS FALSE
              LIMIT :limit OFFSET :offset';

      try {
        $pdo = getDatabaseConnection();
        $sqlCount = "SELECT COUNT(*) FROM news";
        $stmt = $pdo->prepare($sqlCount);
        $stmt->execute();

        $total_records = $stmt->fetchColumn();

        $limit = 5;
        $total_pages = ceil($total_records / $limit);

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($news as $new) {
          ?>
          <article class="grid-item">
            <a href="news/<?= htmlspecialchars($new['slug'], ENT_QUOTES, "UTF-8") ?>">
              <div class="image-container">
                <div class="skeleton"></div>
                <img src="/images/News/uploads/<?= htmlspecialchars($new['banner'], ENT_QUOTES, "UTF-8") ?>"
                  class="lazy-load" />
              </div>
              <h3>
                <?= htmlspecialchars($new['title'], ENT_QUOTES, "UTF-8") ?>
              </h3>
            </a>
          </article>
          <?php
        }
        ;
      } catch (PDOException $e) {
        header("Location: /pages/errors/500.php");
        exit;
      }
      ?>
    </div>
    <div class="pagination">
      <?php
      $limit = 2;
      $begin = max(1, $page - $limit);
      $end = min($total_pages, $page + $limit);
      ?>

      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">&laquo;</a>
      <?php endif; ?>

      <?php if ($begin > 1): ?>
        <a href="?page=1">1</a>
        <?php if ($begin > 2): ?>
          <span>...</span>
        <?php endif; ?>
      <?php endif; ?>

      <?php for ($i = $begin; $i <= $end; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>

      <?php if ($end < $total_pages): ?>
        <?php if ($end < $total_pages - 1): ?>
          <span>...</span>
        <?php endif; ?>
        <a href="?page=<?= $total_pages ?>"><?= $total_pages ?></a>
      <?php endif; ?>

      <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>">&raquo;</a>
      <?php endif; ?>
    </div>
  </section>

  <?php
  include_once "../include/footer.php";
  ?>