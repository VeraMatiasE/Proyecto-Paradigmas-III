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
$id_new = $_POST['id'];

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
    $pdo = getDatabaseConnection();

    $sql = "UPDATE news SET title = :title, content = :content, banner = COALESCE(:banner, banner), slug = :slug WHERE id_new = :id_new";

    $slug = generateUniqueSlug($title, $pdo, 'news', 'slug', 5);
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':content' => $jsonContent,
        ':banner' => $banner,
        ':slug' => $slug,
        ':id_new' => $id_new,
    ]);

    echo json_encode(['slug' => $slug]);

} catch (PDOException $e) {
    header("Location: /pages/errors/500.php");
    exit;
}
?>