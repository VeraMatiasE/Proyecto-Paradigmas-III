<?php
require_once "../../include/config/session.php";
require_once "../../include/config/database.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: login/signin.php");
    exit;
}

$scripts = ["color-switch.js", "hamburger-menu.js", "missions/submit_mission.js"];
$title = "Crear Nueva Misión Espacial";
$styles = "create-modif-admin.css";

include_once "../../include/head.php";

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
?>

<body>
    <?php include_once "../../include/header.php"; ?>
    <h1>Crear Nueva Misión Espacial</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Nombre de la Misión:</label>
        <input type="text" name="name" id="name" required>

        <label for="launch_date">Fecha de Lanzamiento:</label>
        <input type="date" name="launch_date" id="launch_date" required>

        <label for="banner">Banner de la Misión:</label>
        <input type="file" name="banner" id="banner" required>

        <label for="description">Descripción:</label>
        <textarea name="description" id="description" rows="4"></textarea>

        <label for="status">Estado:</label>
        <select name="status" id="status" required>
            <?php foreach ($statusOptions as $option): ?>
                <option><?= htmlspecialchars($option['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="agency">Agencia Espacial:</label>
        <select name="agency" id="agency" required>
            <?php foreach ($agencyOptions as $option): ?>
                <option><?= htmlspecialchars($option['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="celestial_object">Objeto Celeste:</label>
        <select name="celestial_object" id="celestial_object" required>
            <?php foreach ($celestialObjectOptions as $option): ?>
                <option><?= htmlspecialchars($option['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="mission_type">Tipo de Misión:</label>
        <select name="mission_type" id="mission_type" required>
            <?php foreach ($missionTypeOptions as $option): ?>
                <option><?= htmlspecialchars($option['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <h2>Detalles de la Misión</h2>
        <label for="launch_site">Sitio de Lanzamiento:</label>
        <input type="text" name="launch_site" id="launch_site">

        <label for="end_date">Fecha de Finalización:</label>
        <input type="date" name="end_date" id="end_date">

        <label for="rocket_type">Tipo de Cohete:</label>
        <input type="text" name="rocket_type" id="rocket_type">

        <label for="mission_duration">Duración de la Misión:</label>
        <input type="text" name="mission_duration" id="mission_duration">

        <label for="crew_size">Tamaño de la Tripulación:</label>
        <input type="number" name="crew_size" id="crew_size" min="0">

        <label for="budget">Presupuesto (USD):</label>
        <input type="number" name="budget" id="budget" step="0.01" min="0">

        <label for="objectives">Objetivos:</label>
        <textarea name="objectives" id="objectives" rows="4"></textarea>

        <label for="achievements">Logros:</label>
        <textarea name="achievements" id="achievements" rows="4"></textarea>

        <button class="button-background" type="submit">Crear Misión</button>
    </form>
    <?php include_once "../../include/footer.php"; ?>
</body>

</html>