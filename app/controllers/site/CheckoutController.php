<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\database\models\CheckoutModel;
use app\database\models\CartModel;

class CheckoutController extends BaseController
{
    private $checkoutModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
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
            header('Location: /login');
            exit();
        }

        try {
            $cartModel = new CartModel();
            $cartTotal = $cartModel->getCartTotal($userId);

            $data = [
                'user_id' => $userId,
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'city' => $_POST['city'],
                'cep' => $_POST['cep'],
                'complement' => $_POST['complement'],
                'card_name' => $_POST['card_name'],
                'card_number' => $_POST['card_number'],
                'expiration_date' => $_POST['expiration_date'],
                'cvv' => $_POST['cvv'],
                'total_amount' => $cartTotal,
                'discount' => $_POST['discount'] ?? 0,
                'payment_status' => 'pending'
            ];

            $this->checkoutModel->createCheckout($data);

            header("Location: /success");
            exit();
        } catch (\Exception $e) {
            $this->view('error', ['message' => $e->getMessage()]);
        }
    }
}
