<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    http_response_code(500);
    exit;
}
$id_user = $_SESSION["id_user"];

require '../../include/config/database.php';
$pdo = getDatabaseConnection();

function generateSlug($title, $pdo)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

    do {
        $randomSuffix = substr(md5(mt_rand()), 0, 5);
        $uniqueSlug = $slug . '-' . $randomSuffix;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE slug = :slug");
        $stmt->execute(['slug' => $uniqueSlug]);
    } while ($stmt->fetchColumn() > 0);

    return $uniqueSlug;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        $slug = generateSlug($title, $pdo);

        $sql = "INSERT INTO posts (title, id_user, description, slug) VALUES (:title, :id_user, :description, :slug)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'id_user' => $id_user, 'description' => $description, 'slug' => $slug]);

        header("Location: discussion/" . urlencode($slug));
        exit;
    } else {
        echo "Por favor, completa todos los campos.";
    }
}

$title = "Nueva Discusión";

$scripts = ["color-switch.js", "hamburger-menu.js"];

$styles = "discussion.css";
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
                <br><br>
                <button type="submit">Crear Post</button>
            </form>
        </section>
    </main>

    <?php
    include_once "../../include/footer.php";
    ?>