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

        // Cria um mock para o repositório de feedback
        $this->feedbackRepositoryMock = $this->createMock(ISchedulingFeedbackRepository::class);

        // Instancia o serviço com o mock do repositório
        $this->service = new SchedulingFeedbackService($this->feedbackRepositoryMock);
    }

    /**
     * @test
     */
    public function createFeedbackShouldSuccessfullyCreateFeedback()
    {
        // Prepara dados válidos de feedback
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => 'Excelente serviço'
        ];

        // Configura expectativa de chamada do método create no repositório
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

        // Chama o método de criação de feedback
        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     */
    public function createFeedbackShouldThrowExceptionWhenCommentIsEmpty()
    {
        // Prepara dados de feedback com comentário vazio
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => ''
        ];

        // Configura expectativa de que o repositório não será chamado
        $this->feedbackRepositoryMock
            ->expects($this->never())
            ->method('create');

        // Espera que uma exceção seja lançada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Por favor, preencha a avaliação");

        // Chama o método de criação de feedback
        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     */
    public function createFeedbackShouldThrowExceptionWhenCommentIsMissing()
    {
        // Prepara dados de feedback sem comentário
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5
        ];

        // Configura expectativa de que o repositório não será chamado
        $this->feedbackRepositoryMock
            ->expects($this->never())
            ->method('create');

        // Espera que uma exceção seja lançada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Por favor, preencha a avaliação");

        // Chama o método de criação de feedback
        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     */
    public function createFeedbackShouldHandleRepositoryException()
    {
        // Prepara dados válidos de feedback
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => 'Excelente serviço'
        ];

        // Configura o repositório para lançar uma exceção
        $this->feedbackRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->willThrowException(new \Exception("Erro ao salvar feedback"));

        // Espera que a exceção do repositório seja propagada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Erro ao salvar feedback");

        // Chama o método de criação de feedback
        $this->service->createFeedback($feedbackData);
    }

    /**
     * @test
     * Testa os dados mínimos necessários para criar um feedback
     */
    public function createFeedbackWithMinimumRequiredFields()
    {
        // Prepara dados mínimos de feedback
        $feedbackData = [
            'scheduling_id' => 123,
            'user_id' => 456,
            'rating' => 5,
            'comment' => 'Feedback simples'
        ];

        // Configura expectativa de chamada do método create no repositório
        $this->feedbackRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($this->callback(function ($feedback) use ($feedbackData) {
                $this->assertInstanceOf(SchedulingFeedbackModel::class, $feedback);
                return true;
            }));

        // Chama o método de criação de feedback
        $this->service->createFeedback($feedbackData);
    }
}
