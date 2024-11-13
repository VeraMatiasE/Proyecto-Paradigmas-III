<?php
require_once "../../include/config/session.php";
if (!isset($_SESSION["id_user"])) {
    http_response_code(500);
    exit;
}
$id_user = $_SESSION["id_user"];

require '../../include/config/database.php';
$pdo = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    require_once "../../include/functions/slug.php";
    if (!empty($title) && !empty($description)) {
        $slug = generateUniqueSlug($title, $pdo, 'posts', 'slug', 5);

        $sql = "INSERT INTO posts (title, id_user, description, slug) VALUES (:title, :id_user, :description, :slug)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => htmlspecialchars($title), 'id_user' => $id_user, 'description' => htmlspecialchars($description), 'slug' => $slug]);

        header("Location: discussion/" . urlencode($slug));
        exit;
    } else {
        $error_message = "Por favor, completa todos los campos.";
    }
}

$title = "Nueva Discusión";

$scripts = ["color-switch.js", "hamburger-menu.js"];

$styles = "create-modif-discussion.css";
include_once "../../include/head.php";
?>

<body>
    <?php
    include_once "../../include/header.php";
    ?>

    <main>
        <section>
            <h1>Crear un nuevo post</h1>
            <form method="post" action="create_post.php">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" required>
                <br><br>
                <label for="description">Descripción:</label>
                <textarea name="description" id="description" required></textarea>
                <?php if (isset($error_message)): ?>
                    <div class="error"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <br><br>
                <button class="button-background" type="submit">Crear Post</button>
            </form>
        </section>
    </main>

    <?php
    include_once "../../include/footer.php";
    ?>