<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\database\Connection;

class CartController extends BaseController
{
    public function vcart()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            return $this->view('login', ['error' => 'Faça login para acessar o carrinho.']);
        }

        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM cart WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $products = $stmt->fetchAll();

        return $this->view('vcart', ['products' => $products]);
    }

    public function addToCart()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit();
        }

        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'] ?? 1;

        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        header('Location: /vcart');
    }

    public function removeFromCart()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: /login');
            exit();
        }

        $cartId = $_POST['cart_id'];

        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('DELETE FROM cart WHERE id = :id AND user_id = :user_id');
        $stmt->execute(['id' => $cartId, 'user_id' => $userId]);

        header('Location: /vcart');
    }
}
