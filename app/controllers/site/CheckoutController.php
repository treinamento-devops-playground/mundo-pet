<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\services\CheckoutService;


class CheckoutController extends BaseController
{
    private $checkoutService;

    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
    }

    public function show()
    {
        $this->view('cart-checkout');
    }

    public function processPayment()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            return $this->jsonResponse(['error' => 'usuario não autenticado'], 401);
        }


        try {
            $paymentData = [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'city' => $_POST['city'],
                'cep' => $_POST['cep'],
                'complement' => $_POST['complement'],
                'card_name' => $_POST['card_name'],
                'card_number' => $_POST['card_number'],
                'expiration_date' => $_POST['expiration_date'],
                'cvv' => $_POST['cvv'],
                'discount' => $_POST['discount'] ?? 0,
                'email' => $_SESSION['email']
            ];

            /*if (empty($name) || empty($city) || empty($address) || empty($cardName) || empty($cardNumber) || empty($expirationDate) || empty($cvv)) {
                return $this->jsonResponse(['error' => 'todos os campos são obrigatorios.']);
            }*/

            $checkoutId = $this->checkoutService->processPayment($userId, $paymentData);

            /*$email = new CheckoutConfimationEmail();
            $email->sendEmail($_SESSION['email'], ['total' => $cartTotal]);
            $email->sendEmail($_SESSION['email'], ['total' => $cartTotal, 'checkout_id' => $userId]);*/

            header("Location: /catalog");
            exit();
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => 'Ocorreu um erro: ' . $e->getMessage()], 500);
        }
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }
}

