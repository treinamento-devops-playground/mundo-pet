<?php

namespace app\controllers;

use app\database\models\ReviewModel;

class ReviewController
{
    private $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    // Método para adicionar avaliação
    public function createReview($productId, $userId, $rating, $comment)
    {
        // Chama o método do Model para adicionar a avaliação
        $isSaved = $this->reviewModel->addReview($productId, $userId, $rating, $comment);

        // Verifica se a avaliação foi salva com sucesso
        if ($isSaved) {
            $_SESSION['review_success'] = 'Avaliação enviada com sucesso!';
        } else {
            $_SESSION['review_error'] = 'Erro ao enviar a avaliação. Tente novamente.';
        }

        // Redireciona para a página do produto
        header('Location: /product/' . $productId);  // Redirecionando para a página do produto
        exit;
    }

    // Método para exibir as avaliações de um produto
    public function showReviews($productId)
    {
        return $this->reviewModel->getReviewsByProductId($productId);
    }

    // Método para calcular a média das avaliações de um produto
    public function getAverageRating($productId)
    {
        return $this->reviewModel->calculateAverageRating($productId);
    }
}
