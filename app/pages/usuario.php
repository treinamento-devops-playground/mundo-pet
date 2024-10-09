<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php?message=login_required");
  exit();
}

// Conexão com o banco de dados SQLite
$dbFilePath = realpath(__DIR__ . '/../api/products.db');
$conn = new SQLite3($dbFilePath);

// Recupera os dados do usuário logado a partir da sessão
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, telefone, password FROM user WHERE id = :id");
$stmt->bindValue(':id', $userId, SQLITE3_INTEGER);
$result = $stmt->execute();

// Preenche os dados do usuário
$userData = $result->fetchArray(SQLITE3_ASSOC);
$username = $userData['username'] ?? '';
$email = $userData['email'] ?? '';
$phone = $userData['telefone'] ?? '';

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil do Usuário - Mundo Pet</title>
  <link rel="stylesheet" href="../css/usuario.css">
</head>

<body>
  <header>
    <nav id="nav-bar">
      <div class="logo">
        <img src="../img/logo.png" alt="Logo Mundo Pet">
      </div>
      <ul class="list-nav">
        <li class="title"><a href="#">Serviços</a></li>
        <li class="title"><a href="#">Loja</a></li>
        <li class="title"><a href="#">Sobre</a></li>
        <li><a href="#"><img src="../img/icons/user.png" alt="Ícone do Usuário"></a></li>
      </ul>

    </nav>
  </header>

  <div id="container">
    <!-- Menu lateral -->
    <aside class="sidebar">
      <h3>Meu Perfil</h3>
    </aside>

    <!-- Área de edição do usuário -->
    <section class="content">
      <!-- Seção de nome do usuário -->
      <div class="user-section">
        <div class="profile-pic">
          <img src="../img/icons/user.png" alt="Foto do usuário">
        </div>
        <div class="user-info">
          <h2><?php echo htmlspecialchars($username); ?></h2>
        </div>
        <a href="#" class="edit-btn">Editar</a>
      </div>

      <!-- Seção de informações pessoais -->
      <div class="personal-info-section">
        <h3>Informações Pessoais</h3>
        <div class="input-container">
          <img src="../img/icons/user-fill.png">
          <input type="text" name="username" placeholder="Nome" value="<?php echo htmlspecialchars($username); ?>">
        </div>
        <div class="input-container">
          <img src="../img/icons/email.png">
          <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="input-container">
          <img src="../img/icons/phone-solid.png">
          <input type="text" name="phone" placeholder="Celular" value="<?php echo htmlspecialchars($phone); ?>">
        </div>
        <div class="input-container">
          <img src="../img/icons/padlock.png">
          <input type="password" name="password" placeholder="Senha" value="<?php echo htmlspecialchars($password); ?>">
        </div>
        <a href="#" class="edit-btn">Editar</a>
      </div>

      <!-- Seção de endereço -->
      <div class="address-section">
        <h3>Endereço</h3>
        <div class="input-container">
          <label for="cidade">Cidade</label>
          <input type="text" id="cidade" value="">
        </div>
        <div class="input-container">
          <label for="uf">UF</label>
          <input type="text" id="uf" value="">
        </div>
        <div class="input-container">
          <label for="rua">Rua</label>
          <input type="text" id="rua" value="">
        </div>
        <div class="input-container">
          <label for="cep">CEP</label>
          <input type="text" id="cep" value="">
        </div>
        <div class="input-container">
          <label for="numero">Nº</label>
          <input type="text" id="numero" value="">
        </div>
        <div class="input-container">
          <label for="complemento">Complemento</label>
          <input type="text" id="complemento" value="">
        </div>
        <a href="#" class="edit-btn">Editar</a>
        <div style="float: right; margin-right: 20px; margin-top: 20px; display:flex;">
          <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </section>
  </div>
</body>

</html>