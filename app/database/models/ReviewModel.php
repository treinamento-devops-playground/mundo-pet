<?php

namespace app\database\models;

use app\database\Connection;
use PDO;
use PDOException;

class ReviewModel
{
    // Função para adicionar uma avaliação
    public static function addReview($productId, $userId, $rating, $comment)
    {
        try {
            $pdo = Connection::getConnection();

            $stmt = $pdo->prepare('INSERT INTO review (product_id, user_id, rating, comment, review_date) 
                                   VALUES (:product_id, :user_id, :rating, :comment, CURRENT_TIMESTAMP)');
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Função para pegar avaliações de um produto
    public static function getReviewsByProductId($productId)
    {
        try {
            $pdo = Connection::getConnection();

            $stmt = $pdo->prepare('SELECT * FROM review WHERE product_id = :product_id');
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
