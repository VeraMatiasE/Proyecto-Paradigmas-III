<?php
$title = "Space PathWays";

$scripts = [
  "color-switch.js",
  "index.js",
  "hamburger-menu.js"
];

$styles = "index.css";
include_once "include/head.php";
?>

<body>
  <?php
  include_once "include/header.php";
  ?>

  <main>
    <section class="intro">
      <div class="intro-content">
        <h1>Space PathWays</h1>
        <p>
          Explora el cosmos y descubre los hitos más significativos en la
          exploración espacial. Desde misiones históricas hasta las más
          recientes, encuentra información detallada sobre cada una de ellas,
          conversa con otros entusiastas y enterate de las últimas Novedades.
        </p>
        <a href="#space-missions" class="continue-arrow">
          <img src="images/ContinueArrow.svg" alt="Continue Arrow" />
        </a>
      </div>
    </section>

    <section id="space-missions">
      <div class="section-content">
        <div class="section-image">
          <img src="images/CuriosityRover.webp" alt="Curiosity Rover" />
        </div>
        <div class="section-info">
          <h6>Información</h6>
          <h3>Misiones Espaciales</h3>
          <p>
            Sumérgete en las misiones que han marcado la historia de la
            exploración espacial. Aprende sobre los objetivos, logros y
            desafíos de cada misión, y cómo han contribuido a expandir nuestro
            conocimiento del universo.
          </p>
          <div class="flex-center">
            <a class="button button-background" href="pages/missions.html">Explorar Más</a>
          </div>
        </div>
      </div>
    </section>

    <section id="forum">
      <div class="section-content">
        <div class="section-image">
          <img src="images/Apollo11.webp" alt="Apollo 11" />
        </div>
        <div class="section-info">
          <h6>Discusiones</h6>
          <h3>Foro</h3>
          <p>
            Únete a la conversación con entusiastas y expertos en nuestro
            foro. Discute las últimas misiones, comparte teorías, y mantente
            al día con las noticias más recientes en la comunidad espacial.
          </p>
          <div class="flex-center">
            <a class="button button-background" href="pages/forum.html">Explorar Más</a>
          </div>
        </div>
      </div>
    </section>

    <section id="news">
      <div class="section-content">
        <div class="section-image">
          <img src="images/JamesWebb.webp" alt="Telescopio JamesWebb" />
        </div>
        <div class="section-info">
          <h6>Actualidad</h6>
          <h3>Noticias</h3>
          <p>
            Mantente informado con las últimas actualizaciones y anuncios del
            mundo de la exploración espacial. Desde lanzamientos de cohetes
            hasta descubrimientos científicos, no te pierdas ninguna novedad.
          </p>
          <div class="flex-center">
            <a class="button button-background" href="pages/news.html">Explorar Más</a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php
  include_once "include/footer.php";
  ?>
