<?php
require_once "../../../include/config/session.php";
require_once "../../../include/config/database.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== "admin") {
    header("Location: ../../login/signin.php");
    exit;
}

if (!isset($_GET['id_user'])) {
    http_response_code(404);
    exit;
}
$id_user = $_GET['id_user'];

$scripts = ["admin/update.js"];
$title = "Editar Usuario";
$styles = "create-modif-admin.css";

include_once "../../../include/head.php";

$pdo = getDatabaseConnection();

$sql = "SELECT * FROM users WHERE id_user = :id_user AND is_deleted = FALSE";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_user' => $id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(404);
    exit;
}
?>

<body>
    <?php include_once "../../../include/header.php"; ?>
    <h1>Editar Usuario</h1>
    <form action="" method="POST" id="editForm">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"
            value="<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="firstname">Nombre:</label>
        <input type="text" name="firstname" id="firstname"
            value="<?= htmlspecialchars($user['firstname'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="lastname">Apellido:</label>
        <input type="text" name="lastname" id="lastname"
            value="<?= htmlspecialchars($user['lastname'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>"
            required>

        <label for="role">Rol:</label>
        <select name="role" id="role" required>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="news" <?= $user['role'] == 'news' ? 'selected' : '' ?>>News</option>
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
        </select>

        <input id="id" type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
        <input id="table" type="hidden" name="table" value="users">
        <button type="submit" class="button-background">Editar Usuario</button>
    </form>
    <?php include_once "../../../include/footer.php"; ?>
</body>

</html>