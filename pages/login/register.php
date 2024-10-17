<?php
$title = "Registrarse";

$styles = "login.css";

include_once "../../include/head.php";
?>
<div class="container">
  <div class="background-side">
    <div class="login-container">
      <div class="logo">
        <img src="/images/Logo.svg" />
      </div>
      <img src="/images/SpacePathways.svg" />
      <form action="#" method="post">
        <div class="flex-center">
          <div class="input-group">
            <label for="firstname">Nombre <span>*</span></label>
            <input id="firstname" type="text" placeholder="Nombre" required />
          </div>
          <div class="input-group">
            <label for="lastname">Apellido <span>*</span></label>
            <input id="lastname" type="text" placeholder="Apellido" required />
          </div>
        </div>
        <div class="input-group">
          <label for="username">Nombre de Usuario <span>*</span></label>
          <input id="username" type="text" placeholder="username" autocomplete="username" required />
        </div>
        <div class="input-group">
          <label for="email">Correo electrónico <span>*</span></label>
          <input id="email" type="email" placeholder="email@example.com" autocomplete="email" required />
        </div>
        <div class="input-group">
          <label for="password">Contraseña <span>*</span></label>
          <input id="password" type="password" placeholder="● ● ● ● ● ● " autocomplete="on" required />
        </div>
        <button type="submit">Registrarse</button>
      </form>
    </div>
  </div>
  <div class="image-side">
    <img src="/images/TrasnbordadorAndEarth.svg" alt="Un transbordador espacial saliendo de la Tierra"
      class="center-image" />
  </div>
</div>
</body>

</html>