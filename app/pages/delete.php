<?php
if (isset($_GET['id'])) {
    try {
       
        $pdo = new PDO('sqlite:products.db');  
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        
        header('Location: admin.php');
        exit;
    } catch (PDOException $e) {
        
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
} else {
    
    echo "ID não especificado.";
}
