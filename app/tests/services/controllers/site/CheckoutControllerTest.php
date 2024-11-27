<?php

namespace tests\controllers\site;

use PHPUnit\Framework\TestCase;
use app\controllers\site\CheckoutController;
use app\services\CheckoutService;

class CheckoutControllerTest extends TestCase
{
    private $checkoutServiceMock;
    private $checkoutController;

    protected function setUp(): void
    {
        // Mock do CheckoutService
        $this->checkoutServiceMock = $this->createMock(CheckoutService::class);

        // Instância do CheckoutController usando o mock
        $this->checkoutController = $this->getMockBuilder(CheckoutController::class)
            ->setMethods(['redirect', 'renderError'])
            ->setConstructorArgs([$this->checkoutServiceMock])
            ->getMock();
    }

    public function testProcessPaymentSuccess()
    {
        // Simula os dados de sessão
        $_SESSION['user_id'] = 1;
        $_SESSION['email'] = 'user@example.com';

        // Simula os dados do formulário
        $_POST = [
            'name' => 'John Doe',
            'address' => '123 Street',
            'city' => 'New York',
            'cep' => '10001',
            'complement' => 'Apt 1',
            'card_name' => 'John Doe',
            'card_number' => '4111111111111111',
            'expiration_date' => '12/25',
            'cvv' => '123',
            'discount' => 10
        ];

        // Configura o mock para retornar um ID de checkout fictício
        $this->checkoutServiceMock
            ->expects($this->once())
            ->method('processPayment')
            ->with(
                $this->equalTo(1),
                $this->arrayHasKey('name')
            )
            ->willReturn(123);

        // Configura o mock para redirecionar após o pagamento
        $this->checkoutController
            ->expects($this->once())
            ->method('redirect')
            ->with('/checkout/success/123');

        // Executa o método do controller
        $this->checkoutController->processPayment();
    }

    public function testProcessPaymentWithoutSession()
    {
        // Remove a sessão do usuário
        unset($_SESSION['user_id']);

        // Configura o mock para redirecionar para a página de login
        $this->checkoutController
            ->expects($this->once())
            ->method('redirect')
            ->with('/login');

        // Executa o método do controller
        $this->checkoutController->processPayment();
    }

    public function testProcessPaymentThrowsException()
    {
        // Simula os dados de sessão
        $_SESSION['user_id'] = 1;
        $_SESSION['email'] = 'user@example.com';

        // Simula os dados do formulário
        $_POST = [
            'name' => 'John Doe',
            'address' => '123 Street',
            'city' => 'New York',
            'cep' => '10001',
            'complement' => 'Apt 1',
            'card_name' => 'John Doe',
            'card_number' => '4111111111111111',
            'expiration_date' => '12/25',
            'cvv' => '123',
            'discount' => 10
        ];

        // Configura o mock para lançar uma exceção
        $this->checkoutServiceMock
            ->expects($this->once())
            ->method('processPayment')
            ->will($this->throwException(new \Exception('Erro ao processar o pagamento')));

        // Configura o mock para exibir a mensagem de erro
        $this->checkoutController
            ->expects($this->once())
            ->method('renderError')
            ->with('Erro ao processar o pagamento');

        // Executa o método do controller
        $this->checkoutController->processPayment();
    }
}
