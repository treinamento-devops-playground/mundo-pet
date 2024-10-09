<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

// Verifica se o administrador está logado
if (!isset($_SESSION['admin'])) {
    header('Location: login.php?message=login_required');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dbFilePath = __DIR__ . '/../api/products.db'; 

    try {
        $pdo = new PDO('sqlite:' . $dbFilePath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('DELETE FROM agendamentos WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../pages/adminAgendamentos.php?message=deleted_successfully');
        exit();
    } catch (PDOException $e) {
        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
        exit;
    }
} else {
    echo 'ID de agendamento não fornecido.';
    exit();
}
?>
