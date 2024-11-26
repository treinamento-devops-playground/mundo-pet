<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\database\models\CheckoutModel;
use app\database\models\CartModel;
use app\services\email\CheckoutConfimationEmail;
use app\services\ProductService;
use League\Plates\Template\Name;

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

  
    /*public function purchaseConfirmation($id){
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $finalizar = $this->checkoutMail->getAgendamentoById($id);
        
        $userId = $_SESSION['user_id'];
        $userEmail = $_SESSION['email'];
        $finalizar = $_POST['compra'];

        if (!$finalizar || $finalizar->getUserId() != $userId) {
            header("Location: /checkout?error=not_found");
            exit();
        }

        try {

            $email = new CheckoutConfirmationEmail();
            $email->sendEmail($userEmail, ['compra' => $finalizar]);

            header("Location: /checkout/$id?success=confimed");
            exit();
        } catch (\Exception $e) {
            header("Location: /checkout/$id?error=exception");
            exit();
        }
    }*/

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

            $name = $_POST['name'] ?? null;

            if (empty($name)) {
                echo "Erro: O campo 'Nome' é obrigatório.";
                exit();
            }

            $name = $_POST['name'] ?? null;
            $city = $_POST['city'] ?? null;
            $address = $_POST['address'] ?? null;
            $cardName = $_POST['card_name'] ?? null;
            $cardNumber = $_POST['card_number'] ?? null;
            $expirationDate = $_POST['expiration_date'] ?? null;
            $cvv = $_POST['cvv'] ?? null;

            if (empty($name) || empty($city) || empty($address) || empty($cardName) || empty($cardNumber) || empty($expirationDate) || empty($cvv)) {
                echo "Todos os campos são obrigatórios!";
                exit();
            }
        

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

            /*$requiredFields = ['name', 'address', 'city', 'cep', 'card_name', 'card_number', 'expiration_date', 'cvv'];

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    echo "Erro: O campo '" . htmlspecialchars($field) . "' é obrigatório.";
                    exit();
                }
            }*/

            $this->checkoutModel->createCheckout($data);

            $email = new CheckoutConfimationEmail();
            $email->sendEmail($_SESSION['email'], ['total' => $cartTotal, 'checkout_id' => $userId]);
            header("Location: /success");
            exit();
        } catch (\Exception $e) {
            echo "Ocorreu um erro ao finalizar a compra: " . $e->getMessage();
        }
    }
}
