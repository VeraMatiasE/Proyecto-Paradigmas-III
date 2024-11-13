<?php

function getNewsInfo(PDO $pdo, string $slug): ?array
{
    $sql = "SELECT id_new, title, content, id_author, banner FROM news AS n 
            WHERE slug = :slug AND is_deleted IS FALSE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["slug" => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

?>