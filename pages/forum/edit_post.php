<?php
require_once "../../include/config/session.php";
if (!isset($_SESSION["id_user"])) {
    http_response_code(500);
    exit;
}
$id_user = $_SESSION["id_user"];

require '../../include/config/database.php';
$pdo = getDatabaseConnection();

if (isset($_GET['slug'])) {
    require '../../include/functions/post_info.php';
    $slug = $_GET['slug'];

    $post_info = getPostInfo($pdo, $slug);

    if (!$post_info) {
        header("Location: /");
        exit;
    }

    $title_discution = $post_info['title'];
    $description = $post_info['description'];
} else {
    header("Location: /");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "../../include/functions/slug.php";
    $title_discution = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title_discution) && !empty($description)) {
        $new_slug = generateUniqueSlug($title_discution, $pdo, 'posts', 'slug', 5);

        $sql = "UPDATE posts SET title = :title, description = :description, slug = :new_slug WHERE slug = :slug AND id_user = :id_user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => htmlspecialchars($title_discution), 'description' => htmlspecialchars($description), 'slug' => $slug, ':new_slug' => $new_slug, 'id_user' => $id_user]);

        header("Location: ../discussion/" . urlencode($new_slug));
        exit;
    } else {
        $error_message = "Por favor, completa todos los campos.";
    }
}

$title = "Editar Discusión";

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
            <h1>Editar el post</h1>
            <form method="post" action="<?php echo urlencode($slug); ?>">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title_discution); ?>"
                    required>
                <label for="description">Descripción:</label>
                <textarea name="description" id="description"
                    required><?php echo htmlspecialchars($description); ?></textarea>
                <?php if (isset($error_message)): ?>
                    <div class="error"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <button class="button-background" type="submit">Actualizar Post</button>
            </form>
        </section>
    </main>

    <?php
    include_once "../../include/footer.php";
    ?>