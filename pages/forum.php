<?php
$title = "Foro de Discusiones";
$scripts = ["color-switch.js", "hamburger-menu.js"];
$styles = "forum.css";
include_once "../include/head.php";
include_once "../include/functions/date.php";
include_once "../include/config/session.php";
?>

<body>
  <?php include_once "../include/header.php"; ?>

  <main>
    <section class="forum-list">
      <h2>Temas de Discusión</h2>
      <hr>
      <?php if (isset($_SESSION['id_user'])): ?>
        <a href="forum/create_post.php" class="create-post-button">+ Crear Post</a>
      <?php endif; ?>

      <?php
      require '../include/config/database.php';
      $pdo = getDatabaseConnection();

      $limit = 10;
      $offset = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : 0;

      $sql = "SELECT slug, username, title, count_comments, created_at
              FROM posts AS p 
              LEFT JOIN users AS u ON p.id_user = u.id_user
              WHERE p.is_deleted IS FALSE
              LIMIT :limit OFFSET :offset";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
      $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($posts) {
        foreach ($posts as $post) {
          ?>
          <a href="forum/discussion/<?php echo htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8'); ?>" class="forum-post">
            <h3><?php echo htmlspecialchars($post["title"], ENT_QUOTES, 'UTF-8'); ?></h3>
            <p>
              Iniciado por: <?php echo htmlspecialchars($post["username"], ENT_QUOTES, 'UTF-8'); ?> | Respuestas:
              <?php echo htmlspecialchars($post["count_comments"], ENT_QUOTES, 'UTF-8'); ?> |
              <?= getFormattedDate($post['created_at']) ?>
            </p>
          </a>
          <?php
        }
      } else {
        echo "<p>No hay temas de discusión disponibles.</p>";
      }
      ?>
    </section>
  </main>

  <?php include_once "../include/footer.php"; ?>