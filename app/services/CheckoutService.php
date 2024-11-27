<?php

namespace app\services;

use app\database\models\CheckoutModel;
use app\database\models\CartModel;
use app\services\email\CheckoutConfimationEmail;
use Exception;

class CheckoutService
{
    private $checkoutModel;
    private $cartModel;
    private $emailService;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
        $this->cartModel = new CartModel();
        $this->emailService = new CheckoutConfimationEmail();
    }

    public function processPayment($userId, $paymentData)
    {
        try{
            $cartTotal = $this->cartModel->getCartTotal($userId);
            if($cartTotal == 0){
                throw new Exception("carrinho vazio.");
            }

            $totalAmount = $this->calculateTotalAmount($cartTotal, $paymentData['discount']);

            $checkoutData = [
                    'user_id' => $userId,
                    'name' => $paymentData['name'],
                    'address' => $paymentData['address'],
                    'city' => $paymentData['city'],
                    'cep' => $paymentData['cep'],
                    'complement' => $paymentData['complement'],
                    'card_name' => $paymentData['card_name'],
                    'card_number' => $paymentData['card_number'],
                    'expiration_date' => $paymentData['expiration_date'],
                    'cvv' => $paymentData['cvv'],
                    'total_amount' => $totalAmount,
                    'discount' => $paymentData['discount'],
                    'payment_status' => 'pending'
            ];

            $checkoutId = $this->checkoutModel->createCheckout($checkoutData);

            $this->cartModel->clearCart($userId);

            
            $this->emailService->sendEmail($paymentData['email'], [
                'total' => $totalAmount,
                'checkout_id' => $checkoutId
            ]);

            return $checkoutId;

        } catch (Exception $e) {
            
            throw new Exception("Erro ao processar o pagamento: " . $e->getMessage());
        }
    }

    private function calculateTotalAmount($cartTotal, $discount)
    {
        if ($discount < 0 || $discount > 100) {
            throw new Exception("Desconto inválido.");
        }

        return $cartTotal - ($cartTotal * ($discount / 100));
    }
}