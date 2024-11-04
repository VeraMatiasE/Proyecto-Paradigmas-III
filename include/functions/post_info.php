<?php

function getPostInfo(PDO $pdo, string $slug): ?array
{
    $sql = "SELECT id_post, username, title, description, count_comments FROM posts AS p 
            LEFT JOIN users AS u ON p.id_user = u.id_user
            WHERE slug = :slug";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["slug" => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

?>