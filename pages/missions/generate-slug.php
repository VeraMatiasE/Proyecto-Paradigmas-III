<?php

include "../../include/config/database.php";
$pdo = getDatabaseConnection();

function createSlug($name)
{
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return rtrim($slug, '-');
}

$sql = "SELECT id_mission, name FROM mission WHERE is_deleted IS FALSE";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$misiones = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($misiones as $mision) {
    echo "<section><h1>$mision[id_mission].$mision[name]</h1><p>Slug:";
    echo createSlug($mision['name']);
    echo "</p></section>";
}