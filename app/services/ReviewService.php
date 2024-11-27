<?php

namespace app\services;

use app\database\models\ReviewModel;
use Exception;

class ReviewService
{
    public function addReview(int $productId, int $userId, int $rating, string $comment): bool
    {
        if (empty($productId) || empty($rating) || empty($comment)) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        return ReviewModel::addReview($productId, $userId, $rating, $comment);
    }

    public function getProductReviews(int $productId): array
    {
        return ReviewModel::getReviewsByProductId($productId);
    }
}

