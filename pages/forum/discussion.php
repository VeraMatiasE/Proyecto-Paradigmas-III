<?php
require_once "../../include/config/session.php";

if (!isset($_GET['slug'])) {
  header("Location: ../../../pages/errors/404.php");
  exit();
}

$slug = filter_input(INPUT_GET, 'slug', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
require '../../include/config/database.php';
require '../../include/functions/post_info.php';


$pdo = getDatabaseConnection();
$post_info = getPostInfo($pdo, $slug);

if (!$post_info) {
  header("Location: ../../../pages/errors/404.php");
  exit();
}

$title = "Discusión: " . htmlspecialchars($post_info["title"], ENT_QUOTES, 'UTF-8');
$id_post = $post_info['id_post'];

$baseScripts = ["forum/response.js", "forum/load_comments.js", "forum/load_replies.js", "color-switch.js", "hamburger-menu.js"];

$additionalScripts = isset($_SESSION['id_user']) ? ["forum/likes_dislikes.js", "forum/new_comment.js"] : [];

$scripts = array_merge($baseScripts, $additionalScripts);

$moduleScripts = ["forum/response.js", "forum/load_replies.js", "forum/load_comments.js", "forum/likes_dislikes.js", "forum/new_comment.js"];

$id_user = $_SESSION['id_user'] ?? null;


$styles = "discussion.css";
include_once "../../include/head.php";
include_once "../../include/functions/date.php";
?>

<body>
  <?php
  include_once "../../include/header.php";
  ?>

  <main>
    <section class="discussion-topic">
      <h2><?php echo htmlspecialchars($post_info["title"], ENT_QUOTES, 'UTF-8') ?></h2>
      <div class="post-info">
        <p>Publicado por: <?php echo htmlspecialchars($post_info["username"], ENT_QUOTES, 'UTF-8') ?></p>
        <p><?php echo htmlspecialchars($post_info["count_comments"], ENT_QUOTES, 'UTF-8') ?> Comentarios</p>
        <p><?= getFormattedDate($post_info['created_at']) ?></p>
      </div>
      <div class="post-content">
        <p>
          <?php echo htmlspecialchars($post_info["description"], ENT_QUOTES, 'UTF-8') ?>
        </p>
      </div>
      <?php if ($id_user === $post_info['id_user']): ?>
        <a href="../edit_post/<?php echo $slug ?>" class="edit-button">Editar</a>
      <?php endif; ?>
    </section>

    <section class="reply">
      <h3>Responder a esta discusión</h3>
      <form action="#" method="POST">
        <textarea name="reply-content" placeholder="Escribe acá tu respuesta..." required></textarea>
        <button type="submit">Enviar Respuesta</button>
      </form>
    </section>

    <section class="responses">
      <h3>Respuestas</h3>
      <?php
      require '../../include/functions/comments.php';
      $comments = getMainComments($pdo, $id_post, 0, 3, $id_user);
      foreach ($comments as $comment) {
        $comment['replies'] = getRepliesWithLimit($pdo, $comment['id_comment'], 1, 3, $id_user);
        renderComments([$comment], 3);
      }

      ?>

    </section>
    <div id="sentinela"></div>
  </main>

  <?php
  include_once "../../include/footer.php";
  ?>