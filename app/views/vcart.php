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
    <link rel="stylesheet" href="../css/vcart.css">
</head>

<body>
<header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>
        <ul class="list-nav">
            <li class="title"><a href="/services">Serviços</a></li>
            <li class="title"><a href="/product">Loja</a></li>
            <li class="title"><a href="#">Contato</a></li>
            <li><a href="user/edit"><img src="../img/icons/user.png" alt="Usuário"></a></li>
        </ul>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquisar produtos...">
            <button id="search-btn">
                <img src="../img/icons/lupa.png" alt="Pesquisar" class="search-icon">
            </button>
        </div>
    </header>
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


    <div class="button-container">
        <a href="/catalog" class="button continuar-btn">Continuar Comprando</a>
        <a href="/checkout" class="button checkout-btn">Finalizar Compra</a>
    </div>

</body>

</html>