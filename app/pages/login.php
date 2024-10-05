<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Mundo Pet</title>
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div id="container">
    <img src="../img/logo.png" alt="Logo Mundo Pet" class="logo">
    <h2>Login</h2>

    <?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }


    if (isset($_GET['message']) && $_GET['message'] === 'login_required') {
      echo "<p style='color:red;'>É necessário fazer o login para acessar a página administrativa.</p>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $adminEmail = 'admin.@mail.com';
      $adminSenha = password_hash('12345678', PASSWORD_DEFAULT);

      if ($email === $adminEmail && password_verify($password, $adminSenha)) {
        $_SESSION['admin'] = $adminEmail;

        header("Location: admin.php");
        exit();
      } else {
        $conn = new SQLite3('products.db');

        $stmt = $conn->prepare("SELECT id, email, senha FROM usuarios WHERE email = :email");
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $result = $stmt->execute();

        $user = $result->fetchArray(SQLITE3_ASSOC);
        if ($user) {

          if (password_verify($password, $user['senha'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];


            header("Location: home.php");
            exit();
          } else {
            echo "<p style='color:red;'>Email ou senha inválidos.</p>";
          }
        } else {
          echo "<p style='color:red;'>Email ou senha inválidos.</p>";
        }

        $stmt->close();
      }
    }
    ?>


    <form method="POST" action="">
      <div class="input-container">
        <img src="../img/icons/email.png">
        <input type="email" placeholder="Email" id="email" name="email" required>
      </div>
      <div class="input-container">
        <img src="../img/icons/padlock.png">
        <input type="password" placeholder="Senha" id="password" name="password" required>
      </div>
      <button class="btn" name="entrar">Entrar</button>
    </form>

    <a href="./cadastro.php" class="link-cadastro">Cadastre-se</a>
    <div class="social-login">
      <a href="#"><img src="../img/icons/google.png" alt="Logo google"></a>
      <a href="#"><img src="../img/icons/facebook.png" alt="Logo facebook"></a>
    </div>
  </div>
</body>

</html>