<?php
try {
    // Caminho para o banco de dados
    $db_path = __DIR__ . '../products.db';

    // Conexão usando PDO
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $telefone = trim($_POST['telefone']);

        // Verificar se todos os campos foram preenchidos
        if (!empty($username) && !empty($email) && !empty($password) && !empty($telefone)) {
            // Criar o hash da senha antes de armazená-la
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Preparar e executar a consulta usando PDO
            $stmt = $db->prepare("INSERT INTO user (username, email, password, telefone) VALUES (:username, :email, :password, :telefone)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':telefone', $telefone);

            if ($stmt->execute()) {
                echo "Usuário cadastrado com sucesso!";
                header('Location: ../pages/login.php');
                exit;
            } else {
                echo "Erro ao cadastrar.";
            }
        } else {
            echo "Por favor, preencha todos os campos!";
        }
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
