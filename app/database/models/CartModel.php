<?php

namespace app\database\models;

use app\database\Connection;
use PDO;

class CartModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getConnection();
    }

    public function getCartTotal($userId)
    {
        // Calcula o total do carrinho para o usuário especificado
        $stmt = $this->pdo->prepare('
            SELECT SUM(p.price * c.quantity) AS total
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id
        ');

        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retorna o total, ou 0 se não houver produtos
        return $result['total'] !== null ? (float)$result['total'] : 0.0;
    }

    public function getCartItems($userId)
    {
        $stmt = $this->pdo->prepare('
            SELECT c.id, p.name, p.price, c.quantity
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id
        ');

        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($userId, $productId, $quantity)
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO cart (user_id, product_id, quantity)
            VALUES (:user_id, :product_id, :quantity)
            ON DUPLICATE KEY UPDATE quantity = quantity + :quantity
        ');

        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    public function removeFromCart($cartId, $userId)
    {
        $stmt = $this->pdo->prepare('
            DELETE FROM cart
            WHERE id = :cart_id AND user_id = :user_id
        ');

        $stmt->execute([
            'cart_id' => $cartId,
            'user_id' => $userId
        ]);
    }
}
