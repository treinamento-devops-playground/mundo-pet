<?php
try {
    $db = new PDO('sqlite:user.db', '', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, nome TEXT, email TEXT, senha TEXT, telefone TEXT)');
    if (isset($_POST['cadastrar'])) {
        $stmt = $db->prepare('INSERT INTO users (nome, email, senha, telefone ) VALUES (?, ?, ?, ?)');
        $stmt->execute([$_POST['nome'], $_POST['email'], password_hash($_POST['senha'], PASSWORD_DEFAULT), $_POST['telefone']]);
        header('Location: servicos.php');
        exit;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}