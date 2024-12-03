<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use app\services\SchedulingFeedbackService;
use app\database\repositories\ISchedulingFeedbackRepository;
use app\database\models\SchedulingFeedbackModel;

class SchedulingFeedbackServiceTest extends TestCase
{
    private $feedbackRepositoryMock;
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->feedbackRepositoryMock = $this->createMock(ISchedulingFeedbackRepository::class);

        $this->service = new SchedulingFeedbackService($this->feedbackRepositoryMock);
    }

    /**
     * @test
     * Testa se o método createFeedback do serviço está criando um feedback corretamente
     */
    public function createFeedbackShouldSuccessfullyCreateFeedback()
    {
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => 'Excelente serviço'
        ];

        $this->feedbackRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->callback(function ($feedback) use ($feedbackData) {
                $this->assertInstanceOf(SchedulingFeedbackModel::class, $feedback);
                $this->assertEquals($feedbackData['scheduling_id'], $feedback->getSchedulingId());
                $this->assertEquals($feedbackData['user_id'], $feedback->getUserId());
                $this->assertEquals($feedbackData['rating'], $feedback->getRating());
                $this->assertEquals($feedbackData['comment'], $feedback->getComment());
                return true;
            }));

        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     * Testa se o método createFeedback do serviço está lançando uma exceção quando o comentário está vazio
     */
    public function createFeedbackShouldThrowExceptionWhenCommentIsEmpty()
    {
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => ''
        ];

        $this->feedbackRepositoryMock
            ->expects($this->never())
            ->method('create');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Por favor, preencha a avaliação");

        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     * Testa se o método createFeedback do serviço está lançando uma exceção quando o comentário está faltando
     */
    public function createFeedbackShouldThrowExceptionWhenCommentIsMissing()
    {
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5
        ];

        $this->feedbackRepositoryMock
            ->expects($this->never())
            ->method('create');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Por favor, preencha a avaliação");

        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     * Testa se o método createFeedback do serviço está lidando com exceções lançadas pelo repositório
     */
    public function createFeedbackShouldHandleRepositoryException()
    {
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => 'Excelente serviço'
        ];

        $this->feedbackRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->willThrowException(new \Exception("Erro ao salvar feedback"));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Erro ao salvar feedback");

        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     * Testa os dados mínimos necessários para criar um feedback
     */
    public function createFeedbackWithMinimumRequiredFields()
    {

        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => 'Feedback simples'
        ];

        $this->feedbackRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->callback(function ($feedback) use ($feedbackData) {
                $this->assertInstanceOf(SchedulingFeedbackModel::class, $feedback);
                return true;
            }));

        $this->service->createFeedback($feedbackData);
    }
}
