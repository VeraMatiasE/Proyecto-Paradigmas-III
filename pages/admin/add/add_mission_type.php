<?php
require_once "../../../include/config/session.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: login/signin.php");
    exit;
}

$scripts = ["admin/add.js"];
$title = "Agregar Tipo de Misión";
$styles = "create-modif-admin.css";

include_once "../../../include/head.php";
?>

<body>
    <?php include_once "../../../include/header.php"; ?>
    <h1>Agregar Tipo de Misión</h1>
    <form action="" method="POST" enctype="multipart/form-data" id="addForm">
        <label for="name">Nombre del Tipo de Misión:</label>
        <input type="text" name="name" id="name" required>

        <label for="logo">Logo del Tipo de Misión:</label>
        <input type="file" name="logo" id="logo">

        <input id="table" type="hidden" name="table" value="mission_type">
        <button type="submit" class="button-background">Agregar Tipo de Misión</button>
    </form>
    <?php include_once "../../../include/footer.php"; ?>
</body>

</html>