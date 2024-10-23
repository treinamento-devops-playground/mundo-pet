<?php

namespace app\database\models;

use PDO;
use app\database\Connection;

class CartModel
{
    public static function addProduct($userId, $productId, $quantity = 1)
    {
        $pdo = Connection::getConnection();

        // Verificar se o produto já está no carrinho do usuário
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $item = $stmt->fetch();

        if ($item) {
            // Atualiza a quantidade se o produto já estiver no carrinho
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE id = :id");
            return $stmt->execute(['quantity' => $quantity, 'id' => $item['id']]);
        } else {
            // Insere um novo item no carrinho
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
        }
    }

    public static function getCartItems($userId)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("
            SELECT products.id, products.name, products.price, cart.quantity 
            FROM cart 
            JOIN products ON cart.product_id = products.id 
            WHERE cart.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
