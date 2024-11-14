<?php
require_once "config/session.php";
$is_logged = isset($_SESSION["id_user"]) && $_SESSION["username"];
$is_admin = $is_logged && ($_SESSION["role"] === "admin");
$is_news = $is_logged && ($_SESSION["role"] === "admin" || $_SESSION["role"] === "news");
require_once "config/config.php";
?>
<header>
  <div class="top-menu">
    <a href="<?= BASE_PATH ?>/index.php" class="logo">
      <img src="<?= BASE_PATH ?>/images/Logo.svg" alt="Logo" />
      <img src="<?= BASE_PATH ?>/images/SpacePathways.svg" alt="Nombre del sitio" class="logo-name" />
    </a>
    <button class="hamburger" id="hamburger">
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
        <button class="profile-button">▼</button>
        <div id="profile-dropdown" class="profile-dropdown">
          <a href="<?= BASE_PATH ?>/pages/forum/user_discussions.php">Mis Foros</a>
          <?php if ($_SESSION["role"] === "admin" || $_SESSION["role"] === "news"): ?>
            <a href="<?= BASE_PATH ?>/pages/news/user_news.php">Mis Noticias</a>
          <?php endif; ?>
          <?php if ($_SESSION["role"] === "admin"): ?>
            <a href="<?= BASE_PATH ?>/pages/admin/dashboard.php">Dashboard</a>
          <?php endif; ?>
          <a href="<?= BASE_PATH ?>/pages/login/logout.php" class="button button-border logout-button">Cerrar sesión</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</header>