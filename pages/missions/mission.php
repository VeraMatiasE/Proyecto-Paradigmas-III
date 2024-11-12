<?php

if (!isset($_GET['slug'])) {
    header("Location: /pages/errors/404.php");
    exit();
}

$slug = filter_input(INPUT_GET, 'slug', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
require '../../include/config/database.php';
require '../../include/functions/mission_info.php';

$pdo = getDatabaseConnection();
$mission_info = getMissionInfo($pdo, $slug);

if (!$mission_info) {
    header("Location: /pages/errors/404.php");
    exit();
}

$title = $mission_info['name'];

$scripts = ["color-switch.js", "hamburger-menu.js", "missions/path-rover.js", "missions/orbit-satellite.js", "missions/tabs.js"];

$styles = "mission.css";
include_once "../../include/head.php";
?>

<body>
    <?php
    include_once "../../include/header.php";
    ?>
    <main>
        <div class="container">
            <!-- Pestañas -->
            <div class="tabs">
                <div class="tab active" onclick="showTab('description')">
                    Descripción
                </div>
                <div class="tab" onclick="showTab('details')">Detalles</div>
                <div class="tab" onclick="showTab('trajectory')">Trayectoria</div>
            </div>

            <!-- Contenido de las pestañas -->
            <div id="description" class="tab-content active-tab">
                <div class="header">
                    <div class="left">
                        <div class="status">
                            <img src="../../images/Missions/Icons/<?= htmlspecialchars($mission_info['mission_type_logo'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($mission_info['mission_type'], ENT_QUOTES, 'UTF-8'); ?> Icon" />
                            <p><?= htmlspecialchars($mission_info['mission_type'], ENT_QUOTES, 'UTF-8'); ?></p>


                        </div>
                        <div class="status">
                            <img src="../../images/Missions/Logos/<?= htmlspecialchars($mission_info['celestial_object_logo'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($mission_info['celestial_object'], ENT_QUOTES, 'UTF-8'); ?> Icon" />
                            <p><?= htmlspecialchars($mission_info['celestial_object'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                    <div class="center">
                        <img src="../../images/Missions/Banners/<?= htmlspecialchars($mission_info['banner'], ENT_QUOTES, 'UTF-8'); ?>"
                            alt="<?= htmlspecialchars($mission_info['name'], ENT_QUOTES, 'UTF-8'); ?> Banner"
                            class="rover-img" />
                    </div>
                    <div class="right">
                        <div class="status">
                            <img src="../../images/SpaceAgencies/<?= htmlspecialchars($mission_info['space_agency_logo'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($mission_info['space_agency'], ENT_QUOTES, 'UTF-8'); ?> Icon" />
                            <p><?= htmlspecialchars($mission_info['space_agency'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div class="status inactive">
                            <img src="../../images/Missions/Icons/Inactive.svg" alt="Inactive Icon" />
                            <!--
                            <img src="../../images/SpaceAgencies/<?= htmlspecialchars($mission_info['status_logo'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($mission_info['status'], ENT_QUOTES, 'UTF-8'); ?> Icon" />
-->
                            <p><?= htmlspecialchars($mission_info['status'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <div class="launch-info">
                        <h2><?= htmlspecialchars($mission_info['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <div class="date-launch">
                            <p>
                                <img src="../../images/Missions/Icons/LaunchIcon.svg" alt="Launch Icon" />
                                Fecha De Lanzamiento
                            </p>
                            <p><?= htmlspecialchars($mission_info['launch_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                    <hr />
                    <div class="description">
                        <h2>Descripción</h2>
                        <p><?= htmlspecialchars($mission_info['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            </div>

            <div id="details" class="tab-content">
                <?php $mission_details = getMissionDetails($pdo, $mission_info['id_mission']); ?>
                <h2>Detalles</h2>
                <div class="details-block">
                    <p class="detail-item">
                        <strong>Sitio de Lanzamiento:</strong>
                        <?php echo htmlspecialchars($mission_details['launch_site']); ?>
                    </p>
                    <p class="detail-item">
                        <strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($mission_details['end_date']); ?>
                    </p>
                    <p class="detail-item">
                        <strong>Tipo de Cohete:</strong>
                        <?php echo htmlspecialchars($mission_details['rocket_type']); ?>
                    </p>
                    <p class="detail-item">
                        <strong>Duración de la Misión:</strong>
                        <?php echo htmlspecialchars($mission_details['mission_duration']); ?>
                    </p>
                    <p class="detail-item">
                        <strong>Tamaño de la Tripulación:</strong>
                        <?php echo htmlspecialchars($mission_details['crew_size']); ?>
                    </p>
                    <p class="detail-item">
                        <strong>Presupuesto:</strong>
                        <?php echo number_format($mission_details['budget'], 2, ',', '.'); ?> USD
                    </p>
                    <p class="detail-item">
                        <strong>Objetivos:</strong> <?php echo htmlspecialchars($mission_details['objectives']); ?>
                    </p>
                    <p class="detail-item">
                        <strong>Logros:</strong> <?php echo htmlspecialchars($mission_details['achievements']); ?>
                    </p>
                </div>
            </div>

            <div id="trajectory" class="tab-content">
                <h2>Trayectoria</h2>
                <canvas id="roverCanvas" width="400px" height="300px"></canvas>
                <canvas id="orbitalCanvas" width="400px" height="300px"></canvas>
            </div>
        </div>
    </main>

    <?php
    include_once "../include/footer.php";
    ?>