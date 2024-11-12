<?php
function generateUniqueSlug($title, $pdo, $table, $column = 'slug', $length_suffix = 0)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

    do {
        $uniqueSlug = $slug;

        if ($length_suffix > 0) {
            $randomSuffix = substr(bin2hex(random_bytes(ceil($length_suffix / 2))), 0, $length_suffix);
            $uniqueSlug .= "-$randomSuffix";
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE $column = :slug");
        $stmt->execute(['slug' => $uniqueSlug]);
    } while ($stmt->fetchColumn() > 0);

    return $uniqueSlug;
}
