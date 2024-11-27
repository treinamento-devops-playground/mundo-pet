<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Mockery;
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

    // teste para verificar se o método addReview() funciona com dados válidos.
    public function addReviewShouldSuccessfullyAddReview()
    {
        $productId = 123;
        $userId = 456;
        $rating = 5;
        $comment = "Ótimo produto!";

        $mock = Mockery::mock('alias:app\database\models\ReviewModel');
        $mock->shouldReceive('addReview')
            ->once()
            ->with($productId, $userId, $rating, $comment)
            ->andReturn(true);

        $result = $this->reviewService->addReview($productId, $userId, $rating, $comment);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    
     // esse teste verifica se o método addReview() lança exceção quando os campos obrigatórios estão vazios/inválidos.
    public function addReviewShouldThrowExceptionWhenFieldsAreEmpty()
    {
        $productId = 123;
        $userId = 456;
        $rating = 0;  // Rating vazio
        $comment = "";

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Todos os campos são obrigatórios.");

        $this->reviewService->addReview($productId, $userId, $rating, $comment);
    }

    /**
     * @test
     */

     // esse verifica se o método getProductReviews() retorna as avaliações como um array.
    public function getProductReviewsShouldReturnArray()
    {
        $productId = 123;
        $reviews = [
            ['user_id' => 456, 'rating' => 5, 'comment' => 'Ótimo produto!'],
            ['user_id' => 789, 'rating' => 4, 'comment' => 'Muito bom!'],
        ];

        $mock = Mockery::mock('alias:app\database\models\ReviewModel');
        $mock->shouldReceive('getReviewsByProductId')
            ->once()
            ->with($productId)
            ->andReturn($reviews);

        $result = $this->reviewService->getProductReviews($productId);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }
    // fechar os mocks após cada teste, para não interferir.
    protected function tearDown(): void
    {
        Mockery::close(); // Fechando os mocks do Mockery
        parent::tearDown();
    }
}
