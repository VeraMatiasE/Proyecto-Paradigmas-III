<?php

if (isset($_POST['register'])) {
  require '../../include/config/database.php';

  $pdo = getDatabaseConnection();

  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

  $stmt = $pdo->prepare("SELECT EXISTS (
        SELECT 1 FROM users 
        WHERE username = :username OR email = :email
    ) AS user_exists");
  $stmt->execute(['username' => $username, 'email' => $email]);
  $user_exists = $stmt->fetchColumn();

  if ($user_exists) {
    $error = "El nombre de usuario o el correo electrónico ya están en uso.";
  } else {
    $stmt = $pdo->prepare("INSERT INTO users(firstname, lastname, email, username, password) VALUES(:firstname, :lastname, :email, :username, :password)");
    $stmt->execute([
      "firstname" => $first_name,
      "lastname" => $last_name,
      "username" => $username,
      "email" => $email,
      "password" => $password
    ]);
    header("Location: /index.php");
    exit;
  }
}

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

      <?php
      if (isset($error)) {
        ?>
        <div class="error-dialog">
          <h2>Error</h2>
          <p><?php echo $error; ?></p>
        </div>
        <?php
      }
      ?>

      <form action="#" method="post">
        <div class="flex-center">
          <div class="input-group">
            <label for="firstname">Nombre <span>*</span></label>
            <input id="firstname" type="text" placeholder="Nombre" name="firstname" required />
          </div>
          <div class="input-group">
            <label for="lastname">Apellido <span>*</span></label>
            <input id="lastname" type="text" placeholder="Apellido" name="lastname" required />
          </div>
        </div>
        <div class="input-group">
          <label for="username">Nombre de Usuario <span>*</span></label>
          <input id="username" type="text" placeholder="username" autocomplete="username" name="username" required />
        </div>
        <div class="input-group">
          <label for="email">Correo electrónico <span>*</span></label>
          <input id="email" type="email" placeholder="email@example.com" autocomplete="email" name="email" required />
        </div>
        <div class="input-group">
          <label for="password">Contraseña <span>*</span></label>
          <input id="password" type="password" minlength="8" placeholder="● ● ● ● ● ● " autocomplete="new-password"
            name="password" required />
          <button type="button" id="togglePassword">Mostrar</button>
        </div>
        <button type="submit" name="register">Registrarse</button>
      </form>
    </div>
  </div>
  <div class="image-side">
    <img src="/images/Login/TransbordadorAndEarth.svg" alt="Un transbordador espacial saliendo de la Tierra"
      class="center-image" />
  </div>
</div>
</body>

</html>