<?php

namespace app\controllers\site;

use app\database\models\User;
use app\controllers\ContainerController;

class ServiceController extends ContainerController
{
    public function show()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php?message=login_required");
            exit();
        }

        $userModel = new User();
        $username = $userModel->getUsernameById($_SESSION['user_id']);

        $welcomeMessage = "Usuário logado: " . $username;

        $this->view('services', [
            'title' => 'Serviços - Mundo Pet',
            'username' => $username,
            'welcome_message' => $welcomeMessage
        ]);
    }
}
