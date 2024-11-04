<?php
session_start();
$is_logged = isset($_SESSION["id_user"]) && $_SESSION["username"];
?>
<header>
  <div class="top-menu">
    <a href="/index.php" class="logo">
      <img src="/images/Logo.svg" alt="Logo" />
      <img src="/images/SpacePathways.svg" alt="Nombre del sitio" class="logo-name" />
    </a>

    <button class="hamburger active" id="hamburger">
      <img src="/images/NavFooter/Menu.svg" alt="Menu" />
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
      <img src="/images/NavFooter/LightMode.svg" alt="Modo Claro" class="theme-switcher-light" />
      <img src="/images/NavFooter/DarkMode.svg" alt="Modo Oscuro" class="theme-switcher-dark" />
    </a>
    <?php if (!$is_logged): ?>
      <a href="/pages/login/sigin.php" class="button button-border login-button">Ingresar</a>
      <a href="/pages/login/register.php" class="button button-background login-button">Registrarse</a>
    <?php else: ?>
      <div class="user-info">
        <span class="username"><?= htmlspecialchars($_SESSION["username"]) ?></span>
        <a href="/pages/login/logout.php" class="button button-border logout-button">Cerrar sesión</a>
      </div>
    <?php endif; ?>
  </div>
</header>