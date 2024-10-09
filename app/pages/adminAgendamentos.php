<!DOCTYPE html>
<html lang="pt-br">

<?php
// Verifica se a sessão já está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão se ainda não foi iniciada
}

// Verifica se o administrador está logado
if (!isset($_SESSION['admin'])) {
    // Se não estiver logado, redireciona para a página de login com uma mensagem
    header('Location: login.php?message=login_required');
    exit();
}

$dbFilePath = __DIR__ . '/../api/products.db'; // Mude para o caminho correto do banco de agendamentos

try {
    $pdo = new PDO('sqlite:' . $dbFilePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para buscar todos os agendamentos
    $stmt = $pdo->query("SELECT * FROM agendamentos");
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Agendamentos</title>
    <link rel="stylesheet" href="../css/adminAgendamentos.css">
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
        <!-- Menu lateral -->
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
                    <!-- Botão de logout -->
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>

            <div>
                <section class="agendamento-list-section">
                    <h3>Lista de Agendamentos:</h3>

                    <?php foreach ($agendamentos as $agendamento): ?>
                        <div class="agendamento-item">
                            <div class="agendamento-info">
                                <div class="agendamento-details">
                                    <!-- <p>Animal: <?php echo htmlspecialchars($agendamento['pet_type']); ?></p> -->
                                    <h4>Serviço: <?php echo htmlspecialchars($agendamento['service_type']); ?></h4>
                                    <p>Data: <?php echo htmlspecialchars($agendamento['date']); ?></p>
                                    <p>Hora: <?php echo htmlspecialchars($agendamento['time']); ?></p>
                                    <!-- <p>Animal:<p>Status: <?php echo htmlspecialchars($agendamento['status']); ?></p></p> -->
                                </div>
                            </div>
                            <div class="agendamento-actions">
                                <a href="../api/edit_agendamento.php?id=<?php echo $agendamento['id']; ?>" class="edit-btn">Editar</a>
                                <button class="delete-btn" onclick="confirmDelete(<?php echo $agendamento['id']; ?>)">&#128465;</button> <!-- Ícone de lixeira -->
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="add-agendamento">
                        <a href="admin.php" class="add-agendamento-btn">Painel Principal</a>
                    </div>
                </section>
            </div>
        </section>
    </div>

    <script>
        function confirmDelete(agendamentoId) {
            if (confirm('Tem certeza que deseja excluir este agendamento?')) {
                window.location.href = 'delete_agendamento.php?id=' + agendamentoId;
            }
        }
    </script>
</body>

</html>