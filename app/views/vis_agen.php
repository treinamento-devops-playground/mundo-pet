<?php
session_start();
require_once __DIR__ . '/../database/Connection.php';

use app\database\Connection;

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit("Você precisa estar logado para acessar!.");
}

$userId = $_SESSION['user_id'];

try {
    $pdo = Connection::getConnection();

    // Consulta os dados do usuário logado, incluindo o username
    $stmt = $pdo->prepare(
        'SELECT username FROM users WHERE id = :user_id'
    );
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $username = $user['username']; // Pega o nome de usuário

    // Consulta os agendamentos feitos pelo usuário logado
    $stmt = $pdo->prepare(
        'SELECT  
            scheduling.id,
            scheduling.service_type,
            scheduling.date,
            scheduling.time
        FROM scheduling
        WHERE scheduling.user_id = :user_id'
    );
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $agendItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao exibir lista de agendamentos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Agendamentos</title>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/vis_agen.css">
</head>
<body>
    <div id="nav-bar">
        <?php $this->insert('partials/nav-bar'); ?>
    </div>

    <div class="container">
        <aside class="sidebar">
            <button>Meu Perfil</button>
            <button>Agendamentos</button>
        </aside>

        <main class="content">
            <div class="user-card">
                <img src="../img/icons/user.png" alt="Foto do usuário" class="user-avatar">
                <span class="user-name"><?= htmlspecialchars($username) ?></span>
                <button class="edit-btn">Editar</button>
            </div>

            <?php if (!empty($agendItems)): ?>
                <?php foreach ($agendItems as $item): ?>
                <div class="appointment">
                    <div class="titulo">
                        <p> <?= htmlspecialchars($item['service_type']) ?></p>
                        <p> <?= htmlspecialchars($item['date']) ?></p>
                        <p>Horário: <?= htmlspecialchars($item['time']) ?></p>
                    </div>
                    <div class="button-group">
                        <button class="delete-btn">✖</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Você não tem agendamentos no momento.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
