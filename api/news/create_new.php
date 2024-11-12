<?php
session_start();
require_once '../../include/functions/role.php';
if (!(userHasRole("news") || userHasRole("admin"))) {
    http_response_code(500);
    exit;
}

require_once '../../include/config/database.php';
require "../../include/functions/news_html.php";
require "../../include/functions/images.php";
require "../../include/functions/slug.php";

header('Content-Type: application/json');

$imageUrls = [];
$uploadDir = '../../images/News/uploads';

$title = $_POST['title'];
$content = $_POST['content'];
$id_author = $_SESSION['id_user'];

$allImages = [];
$banner = null;
if (!empty($_FILES['banner'])) {
    $allImages[] = $_FILES['banner'];
}


foreach ($_FILES as $key => $file) {
    if ($key !== 'banner') {
        $allImages[] = $file;
    }
}

$imageUrls = uploadImages($allImages, $uploadDir, !empty($_FILES['banner']));
$banner = !empty($_FILES['banner']) ? $imageUrls[0] : null;
$content = replaceImageUrls($content, $imageUrls, $allImages);

$jsonContent = htmlToJson($content);
try {
    $sql = "INSERT INTO news (title, content, id_author, banner, published_at, slug) VALUES
                (:title, :content, :id_author, :banner, NOW(), :slug)";
    $pdo = getDatabaseConnection();

    $slug = generateUniqueSlug($title, $pdo, 'news', 'slug', 5);

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':content' => $jsonContent,
        ':id_author' => $id_author,
        ':banner' => $banner,
        ':slug' => $slug,
    ]);

    echo json_encode(['slug' => $slug]);

} catch (PDOException $e) {
    header("Location: /pages/errors/500.php");
    exit;
}
?>