<?php

namespace app\controllers\site;

use app\database\models\UserModel;
use app\controllers\BaseController;

class ServiceController extends BaseController
{
    public function show()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php?message=login_required");
            exit();
        }

        $userModel = new UserModel();
        $username = $userModel->getUsernameById($_SESSION['user_id']);

        $welcomeMessage = "Usuário logado: " . $username;

        $this->view('services', [
            'title' => 'Serviços - Mundo Pet',
            'username' => $username,
            'welcome_message' => $welcomeMessage
        ]);
    }
}
