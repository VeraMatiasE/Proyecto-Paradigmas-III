<?php
$title = "Misiones Espaciales";

$scripts = ["color-switch.js", "hamburger-menu.js", "missions/loading-image.js"];

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

        $sql = 'SELECT m.name AS mission_name, m.slug, launch_date, description, banner, 
        my.name AS mission_type, my.logo AS logo_mission_type, co.name AS celestial_name, 
        sa.name AS agency_name, sa.logo FROM mission AS m
        LEFT JOIN celestial_object AS co ON co.id_celestial_object = m.id_celestial_object
        LEFT JOIN mission_type AS my ON my.id_mission_type = m.id_mission_type
        LEFT JOIN space_agency AS sa ON sa.id_agency = m.id_agency
        WHERE m.is_deleted IS FALSE
        LIMIT :limit OFFSET :offset';

        try {
          $pdo = getDatabaseConnection();
          $sqlCount = "SELECT COUNT(*) FROM mission";
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
          $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($missions as $mission) {
            ?>

            <div class="mission-card">
              <a href="missions/<?= $mission['slug'] ?>" class="mission-link">
                <div class="mission-image">
                  <div class="image-container">
                    <div class="skeleton"></div>
                    <img src="../images/Missions/Banners/<?= htmlspecialchars($mission['banner'], ENT_QUOTES, 'UTF-8'); ?>"
                      alt="<?= htmlspecialchars($mission['mission_name'], ENT_QUOTES, 'UTF-8'); ?> Misión"
                      class="lazy-load" />
                  </div>
                  <img src="../images/SpaceAgencies/<?= htmlspecialchars($mission['logo'], ENT_QUOTES, 'UTF-8'); ?>"
                    alt=" Logo de de <?= htmlspecialchars($mission['agency_name'], ENT_QUOTES, 'UTF-8'); ?>"
                    class="agency-logo" />
                </div>
                <div class="mission-details">
                  <h3><?= htmlspecialchars($mission['mission_name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                  <div class="mission-info">
                    <div class="icon-info">
                      <img
                        src="../images/Missions/Icons/<?= htmlspecialchars($mission['logo_mission_type'], ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?= htmlspecialchars($mission['mission_type'], ENT_QUOTES, 'UTF-8'); ?> Icon" />
                      <span><?= htmlspecialchars($mission['mission_type'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div class="icon-info">
                      <img src="<?= BASE_PATH ?>/images/Missions/Icons/Planet.svg" alt="Planet Icon" />
                      <span><?= htmlspecialchars($mission['celestial_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div class="icon-info">
                      <img src="/images/Missions/Icons/Calendar.svg" alt="Date Icon" />
                      <span><?= htmlspecialchars($mission['launch_date'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                  </div>
                  <p>
                    <?= htmlspecialchars($mission['description'], ENT_QUOTES, 'UTF-8'); ?>
                  </p>
                  <button class="button-background">Ver Más</button>
                </div>
              </a>
            </div>
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
  </main>

  <?php
  include_once "../include/footer.php";
  ?>