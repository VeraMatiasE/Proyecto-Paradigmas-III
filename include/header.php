<?php
session_start();
$is_logged = isset($_SESSION["id_user"]) && $_SESSION["username"];
require_once "config/config.php";
?>
<header>
  <div class="top-menu">
    <a href="/index.php" class="logo">
      <img src="<?= BASE_PATH ?>/images/Logo.svg" alt="Logo" />
      <img src="<?= BASE_PATH ?>/images/SpacePathways.svg" alt="Nombre del sitio" class="logo-name" />
    </a>

    <button class="hamburger active" id="hamburger">
      <img src="<?= BASE_PATH ?>/images/NavFooter/Menu.svg" alt="Menu" />
    </button>
  </div>

  <nav id="nav-links">
    <ul class="nav-links">
      <li><a href="<?= BASE_PATH ?>/pages/missions.php">Misiones</a></li>
      <li><a href="<?= BASE_PATH ?>/pages/news.php">Noticias</a></li>
      <li><a href="<?= BASE_PATH ?>/pages/forum.php">Foro</a></li>
      <li><a href="<?= BASE_PATH ?>/pages/about.php">Acerca de</a></li>
    </ul>
  </nav>
  <div class="nav-buttons flex-center">
    <a id="theme-switcher" class="theme-switcher">
      <img src="<?= BASE_PATH ?>/images/NavFooter/LightMode.svg" alt="Modo Claro" class="theme-switcher-light" />
      <img src="<?= BASE_PATH ?>/images/NavFooter/DarkMode.svg" alt="Modo Oscuro" class="theme-switcher-dark" />
    </a>
    <?php if (!$is_logged): ?>
      <a href="<?= BASE_PATH ?>/pages/login/sigin.php" class="button button-border login-button">Ingresar</a>
      <a href="<?= BASE_PATH ?>/pages/login/register.php" class="button button-background login-button">Registrarse</a>
    <?php else: ?>
      <div class="user-info">
        <span class="username"><?= htmlspecialchars($_SESSION["username"]) ?></span>
        <a href="<?= BASE_PATH ?>/pages/login/logout.php" class="button button-border logout-button">Cerrar sesión</a>
      </div>
    <?php endif; ?>
  </div>
</header>