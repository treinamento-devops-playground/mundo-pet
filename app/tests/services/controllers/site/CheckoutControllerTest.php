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
            ->addMethods(['redirect', 'renderError']) // Usando setMethods() para evitar erros
            ->setConstructorArgs([$this->checkoutServiceMock])
            ->getMock();
    }

    public function testProcessPaymentSuccess()
    {
        $_SESSION['user_id'] = 1;
        $_SESSION['email'] = 'user@example.com';

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

        $this->checkoutServiceMock
            ->expects($this->once())
            ->method('processPayment')
            ->with(
                $this->equalTo(1),
                $this->arrayHasKey('name')
            )
            ->willReturn(123);

        $this->checkoutController
            ->expects($this->once())
            ->method('redirect')
            ->with('/checkout/success/123');

        $this->checkoutController->processPayment();
    }

    public function testProcessPaymentWithoutSession()
    {
        unset($_SESSION['user_id']);

        $this->checkoutController
            ->expects($this->once())
            ->method('redirect')
            ->with('/login');

        $this->checkoutController->processPayment();
    }

    public function testProcessPaymentThrowsException()
    {
        $_SESSION['user_id'] = 1;
        $_SESSION['email'] = 'user@example.com';

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

        $this->checkoutServiceMock
            ->expects($this->once())
            ->method('processPayment')
            ->will($this->throwException(new \Exception('Erro ao processar o pagamento')));

        $this->checkoutController
            ->expects($this->once())
            ->method('renderError')
            ->with('Erro ao processar o pagamento');

        $this->checkoutController->processPayment();
    }
}
