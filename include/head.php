<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Space PathWays'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <?php
    require_once "config/config.php";

    if (isset($alt_font)) {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($alt_font) . '">' . "\n";
    } else {
        ?>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
            rel="stylesheet" />
        <?php
    }
    ?>

    <link rel='icon' href='<?= BASE_PATH ?>/images/favicon.ico' type='image/x-icon' />
    <?php
    if (isset($scripts) && is_array($scripts)) {
        if (isset($relative_path_scripts)) {
            echo "<script>const BASE_PATH = '$relative_path_scripts';</script>";
        }
        foreach ($scripts as $script) {
            $isModule = isset($moduleScripts) ? in_array($script, $moduleScripts) : false;
            echo '<script src="' . BASE_PATH . '/js/' . htmlspecialchars($script) . '" ' . ($isModule ? 'type="module"' : '') . ' defer></script>' . "\n";
        }
    }

    if (isset($styles)) {
        echo '<link rel="stylesheet" href="' . BASE_PATH . '/styles/css/' . htmlspecialchars($styles) . '">' . "\n";
    }
    ?>
</head>