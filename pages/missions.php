<?php
$title = "Misiones Espaciales";

$scripts = ["color-switch.js", "hamburger-menu.js"];

$styles = "listmissions.css";
include_once "../include/head.php";
?>

<body>
  <?php
  include_once "../include/header.php";
  ?>

  <main>
    <section>
      <h1>Últimas Misiones</h1>
      <hr />
      <div class="mission-list">
        <?php

        include '../include/config/database.php';

        $sql = 'SELECT launch_date, status, description, 
        my.name AS mission_type, co.name AS celestial_name, sa.name AS agency_name, sa.logo FROM mission AS m
        LEFT JOIN celestial_object AS co ON co.id_celestial_object = m.id_celestial_object
        LEFT JOIN mission_type AS my ON my.id_mission_type = m.id_mission_type
        LEFT JOIN space_agency AS sa ON sa.id_agency = m.id_agency';

        try {
          //$stmt = $pdo->query($sql);
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($missions as $mission) {
            ?>

            <div class="mission-card">
              <a href="missions/curiosity.html" class="mission-link">
                <div class="mission-image">
                  <img src="/images/Missions/Banners/Curiosity.jpg" alt="Curiosity Mission" />
                  <img src=<?php echo "/images" . $mission['logo'] ?> alt="Logo de la Nasa" class="agency-logo" />
                </div>
                <div class="mission-details">
                  <h3><?php echo $mission['mission_type'] ?></h3>
                  <div class="mission-info">
                    <div class="icon-info">
                      <img src="/images/Missions/Icons/MarsRover.svg" alt="Rover Icon" />
                      <span><?php echo $mission['mission_type'] ?></span>
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
          <?php
          }
          ;
        } catch (PDOException $e) {
          //header("Location: /error.php");
          //exit;
          echo $e->getMessage();
        }
        ?>

      <div class="pagination">
        <span>1..10</span>
        <button class="next-page">→</button>
      </div>
    </section>
  </main>

  <?php
  include_once "../include/footer.php";
  ?>