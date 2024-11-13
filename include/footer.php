<?php
require_once "config/config.php";
?>
<footer>
  <div class="footer-container">
    <div class="footer-section">
      <div class="logo">
        <img src="<?= BASE_PATH ?>/images/Logo.svg" />
        <img src="<?= BASE_PATH ?>/images/SpacePathways.svg" class="logo-name" />
      </div>
      <p>"Descubre las últimas novedades del Espacio"</p>
    </div>
    <div class="footer-section explore">
      <h3>Explorar</h3>
      <ul>
        <li><a href="<?= BASE_PATH ?>/pages/missions.php">Misiones</a></li>
        <li><a href="<?= BASE_PATH ?>/pages/news.php">Noticias</a></li>
        <li><a href="<?= BASE_PATH ?>/pages/forum.php">Foro</a></li>
        <li><a href="<?= BASE_PATH ?>/pages/about.php">Acerca De</a></li>
      </ul>
    </div>
    <div class="footer-section contact">
      <h3>Contacto</h3>
      <div class="social-icons">
        <a href="#">
          <img src="<?= BASE_PATH ?>/images/SocialNetworks/Linkedin.svg" class="filter-img" alt="Icono de Linkedin" />
        </a>
        <a href="#"><img src="<?= BASE_PATH ?>/images/SocialNetworks/Instagram.svg" class="filter-img"
            alt="Icono de Instagram" />
        </a>
        <a href="#"><img src="<?= BASE_PATH ?>/images/SocialNetworks/Gmail.svg" class="filter-img"
            alt="Icono de Gmail" />
        </a>
        <a href="#"><img src="<?= BASE_PATH ?>/images/SocialNetworks/X.svg" class="filter-img"
            alt="Icono de X o Twitter" />
        </a>
        <a href="#">
          <img src="<?= BASE_PATH ?>/images/SocialNetworks/Github.svg" class="filter-img" alt="Icono de Github" />
        </a>
      </div>
      <p>matiasezequielvera@gmail.com</p>
      <p>Posadas, Misiones</p>
    </div>
  </div>
  <div class="footer-copy">
    <p>Copyright © Vera Matías</p>
  </div>
</footer>
</body>

</html>