<?php
$title = "Foro de Discusiones";

$scripts = ["color-switch.js", "hamburger-menu.js"];

$styles = "forum.css";
include_once "../include/head.php";
?>

<body>
  <?php
  include_once "../include/header.php";
  ?>

  <main>
    <section class="new-discussion">
      <h2>Iniciar una Nueva Discusión</h2>
      <form action="#" method="POST">
        <input type="text" name="title" placeholder="Título de la discusión" required />
        <textarea name="content" placeholder="Escribe acá tu mensaje..." required></textarea>
        <button type="submit">Publicar</button>
      </form>
    </section>

    <section class="discussion-list">
      <h2>Temas de Discusión</h2>
      <?php
      require '../include/config/database.php';

      $pdo = getDatabaseConnection();

      $limit = 10;
      $offset = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : 0;

      $sql = "SELECT slug, username, title, count_comments FROM posts AS p 
                LEFT JOIN users AS u ON p.id_user = u.id_user
                LIMIT :limit OFFSET :offset";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
      $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($posts) {
        foreach ($posts as $post) {
          ?>
          <div class="discussion">
            <h3>
              <!--
              <a href="forum/discussion.php?slug=<?php echo htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8'); ?>">
        -->
              <a href="forum/discussion/<?php echo htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($post["title"], ENT_QUOTES, 'UTF-8'); ?>
              </a>
            </h3>
            <p>
              Iniciado por: <?php echo htmlspecialchars($post["username"], ENT_QUOTES, 'UTF-8') ?> | Respuestas:
              <?php echo htmlspecialchars($post["count_comments"], ENT_QUOTES, 'UTF-8') ?> | Última
              actualización: 27
              de agosto de 2024
            </p>
          </div>
          <?php
        }
      } else {
        echo "<p>No hay temas de discusión disponibles.</p>";
      }

      ?>
    </section>
  </main>

  <?php
  include_once "../include/footer.php";
  ?>