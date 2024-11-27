<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use app\services\ReviewService;
use app\database\models\ReviewModel;
use Exception;

class ReviewServiceTest extends TestCase
{
    private $reviewService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reviewService = new ReviewService();
    }

    /**
     * @test
     */
    public function addReviewShouldSuccessfullyAddReview()
    {
        // Prepara dados válidos de revisão
        $reviewData = [
            'productId' => 123,
            'userId' => 456,
            'rating' => 5,
            'comment' => 'Ótimo produto'
        ];

        // Configura a expectativa de chamada do método addReview no ReviewModel
        $this->mockReviewModelAddReview(true, $reviewData);

        // Chama o método de adicionar a revisão
        $result = $this->reviewService->addReview($reviewData['productId'], $reviewData['userId'], $reviewData['rating'], $reviewData['comment']);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function addReviewShouldThrowExceptionWhenFieldsAreMissing()
    {
        // Prepara dados de revisão com campo vazio
        $reviewData = [
            'productId' => 123,
            'userId' => 456,
            'rating' => 5,
            'comment' => ''
        ];

        // Espera que uma exceção seja lançada
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Todos os campos são obrigatórios.");

        // Chama o método de adicionar a revisão
        $this->reviewService->addReview($reviewData['productId'], $reviewData['userId'], $reviewData['rating'], $reviewData['comment']);
    }

    /**
     * @test
     */
    public function addReviewShouldThrowExceptionWhenRatingIsInvalid()
    {
        // Prepara dados de revisão com rating inválido
        $reviewData = [
            'productId' => 123,
            'userId' => 456,
            'rating' => 0, // Rating inválido
            'comment' => 'Comentário válido'
        ];

        // Espera que uma exceção seja lançada
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Todos os campos são obrigatórios.");

        // Chama o método de adicionar a revisão
        $this->reviewService->addReview($reviewData['productId'], $reviewData['userId'], $reviewData['rating'], $reviewData['comment']);
    }

    /**
     * @test
     */
    public function getProductReviewsShouldReturnReviews()
    {
        // Prepara dados de revisão
        $productId = 123;

        // Mock de chamada do método getReviewsByProductId no ReviewModel
        $reviews = [
            new ReviewModel(123, 456, 5, 'Ótimo produto'),
            new ReviewModel(123, 789, 4, 'Bom produto')
        ];

        $this->mockReviewModelGetReviewsByProductId($reviews);

        // Chama o método de obter as revisões
        $result = $this->reviewService->getProductReviews($productId);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(ReviewModel::class, $result[0]);
    }

    /**
     * @test
     */
    public function getProductReviewsShouldReturnEmptyArrayWhenNoReviews()
    {
        // Prepara dados de revisão
        $productId = 123;

        // Mock de chamada do método getReviewsByProductId no ReviewModel
        $this->mockReviewModelGetReviewsByProductId([]);

        // Chama o método de obter as revisões
        $result = $this->reviewService->getProductReviews($productId);

        $this->assertEmpty($result);
    }

    private function mockReviewModelAddReview(bool $returnValue, array $reviewData)
    {
        $mock = $this->getMockBuilder(ReviewModel::class)
            ->onlyMethods(['addReview'])
            ->getMock();

        $mock->expects($this->once())
            ->method('addReview')
            ->with($reviewData['productId'], $reviewData['userId'], $reviewData['rating'], $reviewData['comment'])
            ->willReturn($returnValue);

        // Substitui a instância do ReviewModel
        $this->reviewService = new ReviewService($mock);
    }

    private function mockReviewModelGetReviewsByProductId(array $reviews)
    {
        $mock = $this->getMockBuilder(ReviewModel::class)
            ->onlyMethods(['getReviewsByProductId'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getReviewsByProductId')
            ->with($this->anything())
            ->willReturn($reviews);

        // Substitui a instância do ReviewModel
        $this->reviewService = new ReviewService($mock);
    }
}
