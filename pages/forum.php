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
        <textarea name="content" placeholder="Escribe aquí tu mensaje..." required></textarea>
        <button type="submit">Publicar</button>
      </form>
    </section>

    <section class="discussion-list">
      <h2>Temas de Discusión</h2>
      <div class="discussion">
        <h3>
          <a href="forum/discussion.html">¿Cuál es la misión espacial más importante?</a>
        </h3>
        <p>
          Iniciado por: Usuario1 | Respuestas: 10 | Última actualización: 27
          de agosto de 2024
        </p>
      </div>
      <div class="discussion">
        <h3>
          <a href="forum/discussion.html">El futuro de la exploración espacial</a>
        </h3>
        <p>
          Iniciado por: Usuario2 | Respuestas: 8 | Última actualización: 26 de
          agosto de 2024
        </p>
      </div>
      <div class="discussion">
        <h3>
          <a href="forum/discussion.html">Impacto de las misiones robóticas en la ciencia</a>
        </h3>
        <p>
          Iniciado por: Usuario3 | Respuestas: 15 | Última actualización: 25
          de agosto de 2024
        </p>
      </div>
    </section>
  </main>

  <?php
  include_once "../include/footer.php";
  ?>