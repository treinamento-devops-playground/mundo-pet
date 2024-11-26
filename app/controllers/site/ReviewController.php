<?php

namespace app\controllers\site;

use app\database\models\ReviewModel;
use PDOException;

class ReviewController
{
    public function addReview()
    {
        session_start(); 

        if (!isset($_SESSION['user_id'])) {
            http_response_code(400);
            echo json_encode(["message" => "Usuário não autenticado"]);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['productId'];
        $rating = $data['rating'];
        $comment = $data['comment'];
        $userId = $_SESSION['user_id']; 

        if (empty($productId) || empty($rating) || empty($comment)) {
            http_response_code(400);
            echo json_encode(["message" => "Todos os campos são obrigatórios"]);
            exit();
        }

        $result = ReviewModel::addReview($productId, $userId, $rating, $comment);

        if ($result) {
            echo json_encode(["message" => "Avaliação salva com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao salvar a avaliação."]);
        }
    }

    // Método para retornar as avaliações de um produto
    public function getProductReviews($productId)
    {
        $reviews = ReviewModel::getReviewsByProductId($productId);
        echo json_encode($reviews);
    }
}
