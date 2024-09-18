<?php
try {
    $pdo = new PDO('sqlite:user.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        throw new Exception('ID inválido.');
    }

    $stmt = $pdo->prepare('SELECT name, email, password FROM users WHERE id = :id');
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        $sql = 'UPDATE users SET name = :name, email = :email';
        // Atualiza a senha apenas se fornecida
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ', password = :password';
        }
        $sql .= ' WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        if (!empty($password)) {
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        }
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();


        header('Location: admin.php');
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
