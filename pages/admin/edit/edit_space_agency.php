<?php
require_once "../../../include/config/session.php";
require_once "../../../include/config/database.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: ../../login/signin.php");
    exit;
}

if (!isset($_GET['id_agency'])) {
    http_response_code(404);
    exit;
}
$id_agency = $_GET['id_agency'];

$scripts = ["admin/update.js"];
$title = "Editar Agencia Espacial";
$styles = "create-modif-admin.css";

include_once "../../../include/head.php";

$pdo = getDatabaseConnection();

$sql = "SELECT * FROM space_agency WHERE id_agency = :id_agency AND is_deleted = FALSE";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_agency' => $id_agency]);
$agency = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agency) {
    http_response_code(404);
    exit;
}
?>

<body>
    <?php include_once "../../../include/header.php"; ?>
    <h1>Editar Agencia Espacial</h1>
    <form action="" method="POST" enctype="multipart/form-data" id="editForm">
        <label for="name">Nombre de la Agencia:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($agency['name'], ENT_QUOTES, 'UTF-8') ?>"
            required>

        <label for="logo">Logo de la Agencia:</label>
        <?php if ($agency['logo']): ?>
            <img src="../../../images/SpaceAgencies/<?= htmlspecialchars($agency['logo'], ENT_QUOTES, 'UTF-8') ?>">
        <?php endif; ?>
        <input type="file" name="logo" id="logo">

        <input id="id" type="hidden" name="id_agency" value="<?= $agency['id_agency'] ?>">
        <input id="table" type="hidden" name="table" value="space_agency">
        <button type="submit" class="button-background">Editar Agencia</button>
    </form>
    <?php include_once "../../../include/footer.php"; ?>
</body>

</html>