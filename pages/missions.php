<?php
$title = "Misiones Espaciales";

$scripts = ["color-switch.js", "hamburger-menu.js"];

$styles = "listmissions.css";

include_once "../include/header.php";
?>

<main>
  <section>
    <h1>Últimas Misiones</h1>
    <hr />
    <div class="mission-list">
      <div class="mission-card">
        <a href="missions/curiosity.html" class="mission-link">
          <div class="mission-image">
            <img src="/images/Missions/Banners/Curiosity.jpg" alt="Curiosity Mission" />
            <img src="/images/SpaceAgencies/Nasa.svg" alt="Logo de la Nasa" class="agency-logo" />
          </div>
          <div class="mission-details">
            <h3>Curiosity</h3>
            <div class="mission-info">
              <div class="icon-info">
                <img src="/images/Missions/Icons/MarsRover.svg" alt="Rover Icon" />
                <span>Rover</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Planet.svg" alt="Planet Icon" />
                <span>Marte</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Calendar.svg" alt="Date Icon" />
                <span>06/08/2012</span>
              </div>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Mauris nec odio...
            </p>
            <button class="button-background">Ver Más</button>
          </div>
        </a>
      </div>

      <div class="mission-card">
        <a href="missions/curiosity.html" class="mission-link">
          <div class="mission-image">
            <img src="/images/Missions/Banners/Curiosity.jpg" alt="Curiosity Mission" />
            <img src="/images/SpaceAgencies/Nasa.svg" alt="Logo de la Nasa" class="agency-logo" />
          </div>
          <div class="mission-details">
            <h3>Curiosity</h3>
            <div class="mission-info">
              <div class="icon-info">
                <img src="/images/Missions/Icons/MarsRover.svg" alt="Rover Icon" />
                <span>Rover</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Planet.svg" alt="Planet Icon" />
                <span>Marte</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Calendar.svg" alt="Date Icon" />
                <span>06/08/2012</span>
              </div>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Mauris nec odio...
            </p>
            <button class="button-background">Ver Más</button>
          </div>
        </a>
      </div>

      <div class="mission-card">
        <a href="missions/curiosity.html" class="mission-link">
          <div class="mission-image">
            <img src="/images/Missions/Banners/Curiosity.jpg" alt="Curiosity Mission" />
            <img src="/images/SpaceAgencies/Nasa.svg" alt="Logo de la Nasa" class="agency-logo" />
          </div>
          <div class="mission-details">
            <h3>Curiosity</h3>
            <div class="mission-info">
              <div class="icon-info">
                <img src="/images/Missions/Icons/MarsRover.svg" alt="Rover Icon" />
                <span>Rover</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Planet.svg" alt="Planet Icon" />
                <span>Marte</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Calendar.svg" alt="Date Icon" />
                <span>06/08/2012</span>
              </div>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Mauris nec odio...
            </p>
            <button class="button-background">Ver Más</button>
          </div>
        </a>
      </div>

      <div class="mission-card">
        <a href="missions/curiosity.html" class="mission-link">
          <div class="mission-image">
            <img src="/images/Missions/Banners/Curiosity.jpg" alt="Curiosity Mission" />
            <img src="/images/SpaceAgencies/Nasa.svg" alt="Logo de la Nasa" class="agency-logo" />
          </div>
          <div class="mission-details">
            <h3>Curiosity</h3>
            <div class="mission-info">
              <div class="icon-info">
                <img src="/images/Missions/Icons/MarsRover.svg" alt="Rover Icon" />
                <span>Rover</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Planet.svg" alt="Planet Icon" />
                <span>Marte</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Calendar.svg" alt="Date Icon" />
                <span>06/08/2012</span>
              </div>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Mauris nec odio...
            </p>
            <button class="button-background">Ver Más</button>
          </div>
        </a>
      </div>

      <div class="mission-card">
        <a href="missions/curiosity.html" class="mission-link">
          <div class="mission-image">
            <img src="/images/Missions/Banners/Curiosity.jpg" alt="Curiosity Mission" />
            <img src="/images/SpaceAgencies/Nasa.svg" alt="Logo de la Nasa" class="agency-logo" />
          </div>
          <div class="mission-details">
            <h3>Curiosity</h3>
            <div class="mission-info">
              <div class="icon-info">
                <img src="/images/Missions/Icons/MarsRover.svg" alt="Rover Icon" />
                <span>Rover</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Planet.svg" alt="Planet Icon" />
                <span>Marte</span>
              </div>
              <div class="icon-info">
                <img src="/images/Missions/Icons/Calendar.svg" alt="Date Icon" />
                <span>06/08/2012</span>
              </div>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Mauris nec odio...
            </p>
            <button class="button-background">Ver Más</button>
          </div>
        </a>
      </div>
    </div>

    <div class="pagination">
      <span>1..10</span>
      <button class="next-page">→</button>
    </div>
  </section>
</main>

<?php
include_once "../include/footer.php";
?>