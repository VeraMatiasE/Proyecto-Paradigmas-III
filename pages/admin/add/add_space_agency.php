<?php
require_once "../../../include/config/session.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: ../../login/signin.php");
    exit;
}

$scripts = ["admin/add.js"];
$title = "Agregar Agencia Espacial";
$styles = "create-modif-admin.css";

include_once "../../../include/head.php";
?>

<body>
    <?php include_once "../../../include/header.php"; ?>
    <h1>Agregar Agencia Espacial</h1>
    <form action="" method="POST" enctype="multipart/form-data" id="addForm">
        <label for="name">Nombre de la Agencia:</label>
        <input type="text" name="name" id="name" required>

        <label for="logo">Logo de la Agencia:</label>
        <input type="file" name="logo" id="logo">

        <input id="table" type="hidden" name="table" value="space_agency">
        <button type="submit" class="button-background">Agregar Agencia</button>
    </form>
    <?php include_once "../../../include/footer.php"; ?>
</body>

</html>