<?php
session_start();


if (!isset($_SESSION['user_id'])) {
  header("Location: login.php?message=login_required");
  exit();
}

$dbFilePath = realpath(__DIR__ . '/../api/products.db');
$conn = new SQLite3($dbFilePath);

// Obter o username a partir do user_id da sessão
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username FROM user WHERE id = :id");
$stmt->bindValue(':id', $userId, SQLITE3_INTEGER);
$result = $stmt->execute();

$username = '';
if ($user = $result->fetchArray(SQLITE3_ASSOC)) {
  $username = $user['username'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Serviços - Mundo Pet</title>
  <link rel="stylesheet" href="../css/servicos.css">
  <script>
    window.onload = function() {
      alert("Você está logado como: <?php echo htmlspecialchars($username); ?>");
    }
  </script>
</head>

<body>
  <nav id="nav-bar">
    <div class="logo">
      <img src="../img/logo.png" alt="Logo Mundo Pet">
    </div>
    <ul class="list-nav">
      <li class="title"><a href="#">Serviços</a></li>
      <li class="title"><a href="#">Loja</a></li>
      <li class="title"><a href="#">Contato</a></li>
      <li><a href="#"><img src="../img/icons/user.png"></a></li>
    </ul>
  </nav>

  <div id="container">
    <div class="cards">
      <div class="card">
        <img src="../img/banho.png">
        <div>
          <a href="#">
            <h3>Banho e Tosa</h3>
            <img src="../img/icons/click.png">
          </a>
        </div>
      </div>
      <div class="card">
        <img src="../img/vacinação.png">
        <div>
          <a href="#">
            <h3>Vacinação</h3>
            <img src="../img/icons/click.png">
          </a>
        </div>
      </div>
      <div class="card">
        <img src="../img/consulta.png">
        <div>
          <a href="#">
            <h3>Consulta Veterinaria</h3>
            <img src="../img/icons/click.png">
          </a>
        </div>
      </div>
    </div>

    <div class="cards">
      <div class="card">
        <img src="../img/adestramento.png">
        <div>
          <a href="#">
            <h3>Adestramento</h3>
            <img src="../img/icons/click.png">
          </a>
        </div>
      </div>
      <div class="card">
        <img src="../img/dogWalter.png">
        <div>
          <a href="#">
            <h3>Dog Walter</h3>
            <img src="../img/icons/click.png">
          </a>
        </div>
      </div>
      <div class="card">
        <img src="../img/store.png">
        <div>
          <a href="#">
            <h3>Lojinha</h3>
            <img src="../img/icons/click.png">
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>