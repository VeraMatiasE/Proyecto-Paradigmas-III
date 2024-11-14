<?php
require_once "../../../include/config/session.php";
require_once "../../../include/config/database.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: login/signin.php");
    exit;
}

if (!isset($_GET['id_celestial_object'])) {
    http_response_code(404);
    exit;
}
$id_celestial_object = $_GET['id_celestial_object'];

$scripts = ["admin/update.js"];
$title = "Editar Objeto Celeste";
$styles = "create-modif-admin.css";

include_once "../../../include/head.php";

$pdo = getDatabaseConnection();

$sql = "SELECT * FROM celestial_object WHERE id_celestial_object = :id_celestial_object AND is_deleted = FALSE";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_celestial_object' => $id_celestial_object]);
$celestial_object = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$celestial_object) {
    http_response_code(404);
    exit;
}
?>

<body>
    <?php include_once "../../../include/header.php"; ?>
    <h1>Editar Objeto Celeste</h1>
    <form action="" method="POST" enctype="multipart/form-data" id="editForm">
        <label for="name">Nombre del Objeto Celeste:</label>
        <input type="text" name="name" id="name"
            value="<?= htmlspecialchars($celestial_object['name'], ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="logo">Logo del Objeto Celeste:</label>
        <?php if ($celestial_object['logo']): ?>
            <img
                src="../../../images/Missions/Logos/<?= htmlspecialchars($celestial_object['logo'], ENT_QUOTES, 'UTF-8') ?>">
        <?php endif; ?>
        <input type="file" name="logo" id="logo">

        <input id="id" type="hidden" name="id_celestial_object" value="<?= $celestial_object['id_celestial_object'] ?>">
        <input id="table" type="hidden" name="table" value="celestial_object">
        <button type="submit" class="button-background">Editar Objeto Celeste</button>
    </form>
    <?php include_once "../../../include/footer.php"; ?>
</body>

</html>