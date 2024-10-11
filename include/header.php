<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo isset($title) ? htmlspecialchars($title) : 'Space PathWays'; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet" />
  <link rel='icon' href='/images/favicon.ico' type='image/x-icon' />
  <?php
  if (isset($scripts) && is_array($scripts)) {
    foreach ($scripts as $script) {
      echo '<script src="/js/' . htmlspecialchars($script) . '" defer></script>' . "\n";
    }
  }

  if (isset($styles)) {
    echo '<link rel="stylesheet" href="/styles/css/' . htmlspecialchars($styles) . '">' . "\n";
  }
  ?>
</head>

<body>

  <header>
    <div class="top-menu">
      <a href="/index.php" class="logo">
        <img src="/images/Logo.svg" />
        <img src="/images/SpacePathways.svg" class="logo-name" />
      </a>

      <button class="hamburger active" id="hamburger">
        <img src="/images/Menu.svg" />
      </button>
    </div>

    <nav id="nav-links">
      <ul class="nav-links">
        <li><a href="/pages/missions.php">Misiones</a></li>
        <li><a href="/pages/news.php">Noticias</a></li>
        <li><a href="/pages/forum.php">Foro</a></li>
        <li><a href="/pages/about.php">Acerca de</a></li>
      </ul>
    </nav>
    <div class="nav-buttons flex-center">
      <a id="theme-switcher" class="theme-switcher">
        <img src="/images/LightMode.svg" class="theme-switcher-light" />
        <img src="/images/DarkMode.svg" class="theme-switcher-dark" />
      </a>
      <a href="/pages/login/sigin.php" class="button button-border login-button">Ingresar
      </a>
      <a href="/pages/login/register.php" class="button button-background login-button">Registrarse
      </a>
    </div>
  </header>