<?php
require_once "../../include/config/session.php";
require_once "../../include/config/database.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: login/signin.php");
    exit;
}

if (!isset($_GET['slug'])) {
    http_response_code(404);
    exit;
}
$slug = $_GET['slug'];

$scripts = ["color-switch.js", "hamburger-menu.js", "missions/submit_mission.js"];
$title = "Editar Misión Espacial";
$styles = "create-modif-admin.css";

include_once "../../include/head.php";

require_once '../../include/config/database.php';
require_once '../../include/functions/mission_info.php';
$pdo = getDatabaseConnection();

function getOptions($pdo, $table)
{
    $sql = "SELECT name FROM " . $table . " WHERE is_deleted IS FALSE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Cargar opciones para cada select
$statusOptions = getOptions($pdo, "status");
$agencyOptions = getOptions($pdo, "space_agency");
$celestialObjectOptions = getOptions($pdo, "celestial_object");
$missionTypeOptions = getOptions($pdo, "mission_type");

$mission_info = getAllInfo($pdo, $slug);
?>

<body>
    <?php include_once "../../include/header.php"; ?>
    <h1>Crear Nueva Misión Espacial</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Nombre de la Misión:</label>
        <input type="text" name="name" id="name"
            value="<?= htmlspecialchars($mission_info['name'], ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="launch_date">Fecha de Lanzamiento:</label>
        <input type="date" name="launch_date" id="launch_date"
            value="<?= htmlspecialchars($mission_info['launch_date'], ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="banner">Banner de la Misión:</label>
        <img
            src="../../../images/Missions/Banners/<?= htmlspecialchars($mission_info['banner'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="file" name="banner" id="banner">

        <label for="description">Descripción:</label>
        <textarea name="description" id="description"
            rows="4"><?= htmlspecialchars($mission_info['description'], ENT_QUOTES, 'UTF-8') ?></textarea>

        <label for="status">Estado:</label>
        <select name="status" id="status" required>
            <?php foreach ($statusOptions as $option): ?>
                <option><?= htmlspecialchars($option['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="agency">Agencia Espacial:</label>
        <select name="agency" id="agency" required>
            <?php foreach ($agencyOptions as $option): ?>
                <option <?php echo ($option['name'] == $mission_info['space_agency']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($option['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="celestial_object">Objeto Celeste:</label>
        <select name="celestial_object" id="celestial_object" required>
            <?php foreach ($celestialObjectOptions as $option): ?>
                <option <?php echo ($option['name'] == $mission_info['celestial_object']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($option['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="mission_type">Tipo de Misión:</label>
        <select name="mission_type" id="mission_type" required>
            <?php foreach ($missionTypeOptions as $option): ?>
                <option <?php echo ($option['name'] == $mission_info['mission_type']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($option['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <h2>Detalles de la Misión</h2>
        <label for="launch_site">Sitio de Lanzamiento:</label>
        <input type="text" name="launch_site" id="launch_site"
            value="<?= htmlspecialchars($mission_info['launch_site'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="end_date">Fecha de Finalización:</label>
        <input type="date" name="end_date" id="end_date"
            value="<?= htmlspecialchars($mission_info['end_date'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="rocket_type">Tipo de Cohete:</label>
        <input type="text" name="rocket_type" id="rocket_type"
            value="<?= htmlspecialchars($mission_info['rocket_type'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="mission_duration">Duración de la Misión:</label>
        <input type="text" name="mission_duration" id="mission_duration"
            value="<?= htmlspecialchars($mission_info['mission_duration'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="crew_size">Tamaño de la Tripulación:</label>
        <input type="number" name="crew_size" id="crew_size" min="0"
            value="<?= htmlspecialchars($mission_info['crew_size'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="budget">Presupuesto (USD):</label>
        <input type="number" name="budget" id="budget" step="0.01" min="0"
            value="<?= htmlspecialchars($mission_info['budget'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="objectives">Objetivos:</label>
        <textarea name="objectives" id="objectives"
            rows="4"><?= htmlspecialchars($mission_info['objectives'], ENT_QUOTES, 'UTF-8') ?></textarea>

        <label for="achievements">Logros:</label>
        <textarea name="achievements" id="achievements"
            rows="4"><?= htmlspecialchars($mission_info['achievements'], ENT_QUOTES, 'UTF-8') ?></textarea>

        <input type="hidden" id="id_mission" name="id_mission" value="<?= $mission_info['id_mission'] ?>">
        <button class="button-background" type="submit">Editar Misión</button>
    </form>
    <?php include_once "../../include/footer.php"; ?>