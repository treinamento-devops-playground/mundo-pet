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
    <form method="POST" action="">
    <div class="input-container">
      <img src="../img/icons/email.png">
      <input type="email" placeholder="Email" id="email" name="email" required>
    </div>
    <div class="input-container">
      <img src="../img/icons/padlock.png">
      <input type="password" placeholder="Senha" id="password" name="password" required>
    </div>
    <button class="btn" name="entrar">Entrar</button> </form>
    <a href="./cadastro.php" class="link-cadastro">Cadastre-se</a>
    <div class="social-login">
      <a href="#"><img src="../img/icons/google.png" alt="Logo google"></a>
      <a href="#"><img src="../img/icons/facebook.png" alt="Logo facebook"></a>
    </div>
  </div>
  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $adminEmail = 'admin.@mail.com';
        $adminSenha = password_hash('12345678', PASSWORD_DEFAULT);

        // Verifica se o usuário foi encontrado e se a senha está correta
        if ($email === $adminEmail && password_verify($password, $adminSenha)) {
            // Redireciona para a página de administração
            header("Location: admin.php");
            exit();
        } else {
          echo "<p</p>";
        }
    }
  ?>
</body>
</html>