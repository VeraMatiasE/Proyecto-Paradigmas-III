<?php
$title = "Noticias Espaciales";

$scripts = ["color-switch.js, hamburger-menu.js"];

$styles = "news.css";
include_once "../include/head.php";
?>

<body>
  <?php
  include_once "../include/header.php";
  ?>

  <section class="main-news">
    <div class="main-article">
      <a href="news/new.html">
        <img src="/images/new.avif" alt="Imagen Principal" />
        <div class="main-article-content">
          <h2>
            El rover Perseverance inicia su exploración en territorio
            inexplorado de Marte
          </h2>
        </div>
      </a>
    </div>
    <div class="secondary-articles">
      <article>
        <a href="news/new.html">
          <img src="/images/new.avif" alt="Imagen Misión 1" />
          <h3>
            El rover Perseverance inicia su exploración en territorio
            inexplorado de Marte
          </h3>
        </a>
      </article>
      <article>
        <a href="news/new.html">
          <img src="/images/new.avif" alt="Imagen Misión 2" />
          <h3>
            El rover Perseverance inicia su exploración en territorio
            inexplorado de Marte
          </h3>
        </a>
      </article>
    </div>
  </section>

  <section>
    <div class="news-header">
      <h2>Últimas Noticias</h2>
      <hr />
    </div>
    <div class="news-grid">
      <article class="grid-item">
        <a href="news/new.html">
          <img src="/images/new.avif" alt="Misión Espacial 1" />
          <h3>
            El rover Perseverance inicia su exploración en territorio
            inexplorado de Marte
          </h3>
          <p>
            Las muestras recopiladas podrían tener implicaciones
            significativas para la comprensión de la historia geológica del
            planeta rojo
          </p>
        </a>
      </article>
      <article class="grid-item">
        <a href="news/new.html">
          <img src="/images/new.avif" alt="Misión Espacial 2" />
          <h3>
            El rover Perseverance inicia su exploración en territorio
            inexplorado de Marte
          </h3>
          <p>
            Las muestras recopiladas podrían tener implicaciones
            significativas para la comprensión de la historia geológica del
            planeta rojo
          </p>
        </a>
      </article>
      <article class="grid-item">
        <a href="news/new.html">
          <img src="/images/new.avif" alt="Misión Espacial 3" />
          <h3>
            El rover Perseverance inicia su exploración en territorio
            inexplorado de Marte
          </h3>
          <p>
            Las muestras recopiladas podrían tener implicaciones
            significativas para la comprensión de la historia geológica del
            planeta rojo
          </p>
        </a>
      </article>
      <article class="grid-item">
        <a href="news/new.html">
          <img src="/images/new.avif" alt="Misión Espacial 4" />
          <h3>
            El rover Perseverance inicia su exploración en territorio
            inexplorado de Marte
          </h3>
          <p>
            Las muestras recopiladas podrían tener implicaciones
            significativas para la comprensión de la historia geológica del
            planeta rojo
          </p>
        </a>
      </article>
    </div>
  </section>

  <?php
  include_once "../include/footer.php";
  ?>