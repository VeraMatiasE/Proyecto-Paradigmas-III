<?php
require_once "../../include/config/session.php";
require '../../include/config/database.php';

$pdo = getDatabaseConnection();

$max_attempts = 5;
$lockout_time = 15 * 60;
$disable_logging = false;
$ip_address = $_SERVER['REMOTE_ADDR'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'];

  $sql_attempts = "SELECT COUNT(*) AS attempts, MAX(attempt_time) AS last_attempt 
                     FROM login_attempts 
                     WHERE ip_address = :ip_address 
                     AND email = :email
                     AND attempt_time > (NOW() - INTERVAL :lockout_time SECOND)";
  $stmt = $pdo->prepare($sql_attempts);
  $stmt->execute(['ip_address' => $ip_address, 'email' => $email, 'lockout_time' => $lockout_time]);
  $attempts_data = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($attempts_data['attempts'] >= $max_attempts) {
    $last_attempt_time = strtotime($attempts_data['last_attempt']);
    $current_time = time();
    $remaining_time = ($last_attempt_time + $lockout_time * 1000) - $current_time;
    if ($remaining_time > 0) {
      $error = "Demasiados intentos fallidos. Intenta de nuevo en " . ceil($remaining_time / 60000) . " minutos.";
      $disable_logging = true;
    }
  } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $sql_user = "SELECT id_user, password, username, role FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql_user);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      session_regenerate_id(true);
      $_SESSION['id_user'] = $user['id_user'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
      header("Location: /index.php");
      exit;
    } else {
      $sql_insert_attempt = "INSERT INTO login_attempts (ip_address, email, attempt_time) VALUES (:ip_address, :email, NOW())";
      $stmt = $pdo->prepare($sql_insert_attempt);
      $stmt->execute(['ip_address' => $ip_address, 'email' => $email]);
      $error = "Credenciales incorrectas.";
    }
  } else {
    $error = "Formato de correo electrónico inválido.";
  }
}
$title = "Login";

$styles = "login.css";

include_once "../../include/head.php";
?>

<body>
  <div class="container">
    <div class="image-side">
      <img src="/images/Login/Transbordador.svg" alt="Un transbordador espacial" class="center-image" />
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
            <input id="email" type="email" placeholder="email@example.com" name="email" <?php echo $disable_logging ? "disabled" : ""; ?> required />
          </div>
          <div class="input-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" placeholder="● ● ● ● ● ● " name="password" <?php echo $disable_logging ? "disabled" : ""; ?> required />
          </div>
          <button type="submit" name="login">Ingresar</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>