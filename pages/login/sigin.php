<?php
session_start();
if (isset($_POST['login'])) {
  require '../../include/config/database.php';

  $pdo = getDatabaseConnection();

  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT password FROM users where email = :email");
  $stmt->execute(['email' => $email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      header("Location: /index.php");
      exit;
    } else {
      $error = "Contraseña incorrecta";
    }
  } else {
    $error = "Usuario no existe";
  }
}
$title = "Login";

$styles = "login.css";

include_once "../../include/head.php";
?>

<body>
  <div class="container">
    <div class="image-side">
      <img src="/images/Transbordador.svg" alt="Un transbordador espacial" class="center-image" />
    </div>
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

        <form action="" method="post">
          <div class="input-group">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" placeholder="email@example.com" name="email" required />
          </div>
          <div class="input-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" placeholder="● ● ● ● ● ● " name="password" required />
          </div>
          <button type="submit" name="login">Ingresar</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>