<?php

if (isset($_GET['id'])) {
    $agendamentoId = $_GET['id'];

    $dbFilePath = __DIR__ . '/agendamentos.db';

    try {
       
        $pdo = new PDO('sqlite:' . $dbFilePath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id = :id");
        $stmt->bindParam(':id', $agendamentoId, PDO::PARAM_INT);
        $stmt->execute();
        $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$agendamento) {
            echo 'Agendamento não encontrado!';
            exit;
        }

    } catch (PDOException $e) {
        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
        exit;
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $petType = $_POST['pet_type'];
        $serviceType = $_POST['service_type'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        try {
            $stmt = $pdo->prepare("UPDATE agendamentos SET pet_type = :pet_type, service_type = :service_type, date = :date, time = :time WHERE id = :id");
            $stmt->bindParam(':pet_type', $petType);
            $stmt->bindParam(':service_type', $serviceType);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':time', $time);
            $stmt->bindParam(':id', $agendamentoId);
            $stmt->execute();

            // redireciona de volta à página de listagem de agendamentos
            header("Location: ../pages/adminAgendamentos.php");
            exit;
        } catch (PDOException $e) {
            echo 'Erro ao atualizar o agendamento: ' . $e->getMessage();
            exit;
        }
    }

} else {
    echo 'ID do agendamento não fornecido!';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo - Mundo Pet</title>
  <link rel="stylesheet" href="../css/admintabela.css">
</head>

<body>
  <header>
    <nav id="nav-bar">
      <div class="logo">
        <img src="../img/logo.png" alt="Logo Mundo Pet">
      </div>
      <ul class="list-nav">
        <li class="title"><a href="#">Serviços</a></li>
        <li class="title"><a href="catalogo.php">Loja</a></li>
        <li class="title"><a href="#">Sobre</a></li>
        <li><a href="#"><img src="../img/icons/user.png"></a></li>
      </ul>
    </nav>
  </header>

  <div id="container">
    <aside class="sidebar">
      <h3>Painel Administrativo</h3>
      <ul>
        <li><a href="#">Usuários</a></li>
        <li><a href="#">Relatórios</a></li>
      </ul>
    </aside>

    <section class="content">
      <div class="user-section">
        <div class="profile-pic">
          <img src="../img/icons/user.png" alt="Foto do administrador">
        </div>
        <div class="user-info">
          <h2>Administrador</h2>
          <a href="login.php" class="logout-btn">Logout</a>
        </div>
      </div>

      <section class="personal-info-section">
        <h3>Atualizar Agendamento</h3>

        <form id="agendamentoForm" action="" method="POST">
          <div class="input-container">
            <label for="pet_type">Tipo de Pet:</label>
            <input type="text" id="pet_type" name="pet_type" value="<?php echo htmlspecialchars($agendamento['pet_type']); ?>" required>
          </div>
          <div class="input-container">
            <label for="service_type">Tipo de Serviço:</label>
            <input type="text" id="service_type" name="service_type" value="<?php echo htmlspecialchars($agendamento['service_type']); ?>" required>
          </div>
          <div class="input-container">
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($agendamento['date']); ?>" required>
          </div>
          <div class="input-container">
            <label for="time">Horário:</label>
            <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($agendamento['time']); ?>" required>
          </div>
          <div class="admin-options">
            <button type="submit" class="admin-btn">Atualizar Agendamento</button>
            <button type="button" class="admin-btn" onclick="window.location.href='../pages/adminAgendamentos.php'">Voltar</button>
          </div>
        </form>

        <div id="successPopup" class="popup" style="display: none;">
          Agendamento atualizado com sucesso!
        </div>

        <div id="errorPopup" class="popup" style="display: none;">
          Erro ao atualizar agendamento.
        </div>
      </section>
    </section>
  </div>
</body>
</html>
