<?php

function getPostInfo(PDO $pdo, string $slug): ?array
{
    $sql = "SELECT id_post, p.id_user, username, title, description, count_comments, created_at FROM posts AS p 
            LEFT JOIN users AS u ON p.id_user = u.id_user
            WHERE slug = :slug AND p.is_deleted IS FALSE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["slug" => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function getIdByName($pdo, $table, $name, $column)
{
    $sql = "SELECT $column FROM $table WHERE name = :name LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result[$column] : null;
}
?>