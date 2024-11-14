<?php
require_once "../../../include/config/session.php";
require_once "../../../include/config/database.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: login/signin.php");
    exit;
}

if (!isset($_GET['id_mission_type'])) {
    http_response_code(404);
    exit;
}
$id_mission_type = $_GET['id_mission_type'];

$scripts = ["admin/update.js"];
$title = "Editar Tipo de Misión";
$styles = "create-modif-admin.css";

include_once "../../../include/head.php";

$pdo = getDatabaseConnection();

$sql = "SELECT * FROM mission_type WHERE id_mission_type = :id_mission_type AND is_deleted = FALSE";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_mission_type' => $id_mission_type]);
$mission_type = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mission_type) {
    http_response_code(404);
    exit;
}
?>

<body>
    <?php include_once "../../../include/header.php"; ?>
    <h1>Editar Tipo de Misión</h1>
    <form action="" method="POST" enctype="multipart/form-data" id="editForm">
        <label for="name">Nombre del Tipo de Misión:</label>
        <input type="text" name="name" id="name"
            value="<?= htmlspecialchars($mission_type['name'], ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="logo">Logo del Tipo de Misión:</label>
        <?php if ($mission_type['logo']): ?>
            <img src="../../../images/Missions/Icons/<?= htmlspecialchars($mission_type['logo'], ENT_QUOTES, 'UTF-8') ?>">
        <?php endif; ?>
        <input type="file" name="logo" id="logo">

        <input id="id" type="hidden" name="id_mission_type" value="<?= $mission_type['id_mission_type'] ?>">
        <input id="table" type="hidden" name="table" value="mission_type">
        <button type="submit" class="button-background">Editar Tipo de Misión</button>
    </form>
    <?php include_once "../../../include/footer.php"; ?>
</body>

</html>