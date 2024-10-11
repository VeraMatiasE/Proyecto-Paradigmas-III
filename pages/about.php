<?php
$title = "Acerca de - Space PathWays";

$scripts = ["js/color-switch.js", "js/hamburger-menu.js"];

$styles = "about.css";

include_once "../include/header.php";
?>

<main>
  <section class="hero">
    <div class="hero-content">
      <h2>Acerca de Space PathWays</h2>
      <p>
        Nuestra misión es llevar el conocimiento sobre la exploración
        espacial a todos los rincones del mundo.
      </p>
    </div>
  </section>

  <section class="content">
    <h3>¿Qué es Space PathWays?</h3>
    <p>
      Space PathWays es un proyecto enfocado en las misiones espaciales. Mi
      objetivo es crear una plataforma donde los apacionados del espacio
      puedan encontrar información sobre las diferentes misiones espaciales
      que han existido, y las que vendrán a futuro. Además, nuestra meta es
      ofrecer un espacio para que la comunidad de aficionados puedan
      compartir sus conocimientos y participe en discusiones, de forma
      moderada, sobre los logros de la humanidad en cuanto a la exploración
      espacial.
    </p>

    <h3>Mi Visión</h3>
    <p>
      Creo que las misiones espaciales son un gran logro de la humanidad y
      fueron un fuente de inspiración para mí. Por eso, quiero brindar un
      espacio para quienes comparten la misma pasión.
    </p>
  </section>

  <section class="about-details">
    <div class="about-content">
      <h2>¿Quién Soy?</h2>
      <p>
        Mi nombre es Matías Vera. Soy un estudiante de la carrera de
        Ingeniería en Sistemas de Información de la universidad de la Cuenca
        del Plata de la ciudad de Posadas, Misiones, Argentina.
      </p>
      <p>
        Mi objetivo es hacer que el conocimiento sobre las misiones
        espaciales sea accesible y emocionante para todos.
      </p>
    </div>
  </section>

  <section class="cta">
    <h3>Únete a Nuestra Comunidad</h3>
    <p>
      Si compartes nuestra pasión por la exploración espacial, únete a
      nuestra comunidad y participa en discusiones, comparte conocimientos,
      y mantente informado sobre las últimas novedades en el campo espacial.
    </p>
    <a href="register.html" class="button button-background">Regístrate</a>
  </section>
</main>

<?php
include_once "../include/footer.php";
?>