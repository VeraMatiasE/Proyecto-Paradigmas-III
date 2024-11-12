<?php

function getNewsInfo(PDO $pdo, string $slug): ?array
{
    $sql = "SELECT id_new, title, content, id_author, banner FROM news AS n 
            WHERE slug = :slug";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["slug" => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

?>