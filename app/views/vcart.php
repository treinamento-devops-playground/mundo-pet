<?php
session_start();
require_once __DIR__ . '/../database/Connection.php';

use app\database\Connection;

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit("Você precisa estar logado para acessar o carrinho.");
}

$userId = $_SESSION['user_id'];

try {
    $pdo = Connection::getConnection();

    $stmt = $pdo->prepare(
        'SELECT 
            cart.id AS cart_item_id, 
            products.name, 
            products.price, 
            cart.quantity 
         FROM cart
         JOIN products ON cart.product_id = products.id
         WHERE cart.user_id = :user_id'
    );
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }
} catch (PDOException $e) {
    die("Erro ao acessar o carrinho: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="../css/catalogo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .cart-container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .remove-btn {
            background-color: red;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <h1>Carrinho de Compras</h1>

        <?php if (empty($cartItems)): ?>
            <p>Seu carrinho está vazio.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>R$ <?= number_format($item['price'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?></td>
                            <td>
                                <form action="/cart/remove" method="POST">
                                    <input type="hidden" name="cart_id" value="<?= $item['cart_item_id'] ?>">
                                    <button type="submit" class="remove-btn">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total">
                <p>Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
            </div>
        <?php endif; ?>
    </div>


    <a href="/product" class="back-link">Continuar Comprando</a>
    <a href="/checkout" class="back-link">Checkout</a>
</body>

</html>