<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\database\models\UserModel;
use core\Request;

class UserController extends BaseController
{
    public function login()
    {
        $message = "";

        if (isset($_GET['message']) && $_GET['message'] === 'login_required') {
            $message = "<p style='color:red;'>É necessário fazer o login para avançar</p>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Request::input('email');
            $password = Request::input('password');

            $userModel = new UserModel();

            if ($email === 'admin@mail.com' && password_verify($password, $userModel->getAdminPassword())) {
                $_SESSION['admin'] = $email;
                header("Location: /admin");
                exit();
            }

            $user = $userModel->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: /services");
                exit();
            } else {
                $message = "<p style='color:red;'>Email ou senha inválidos.</p>";
            }
        }

        return $this->view('user/login', ['message' => $message]);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = Request::input('username');
            $email = Request::input('email');
            $password = password_hash(Request::input('password'), PASSWORD_DEFAULT);
            $telefone = Request::input('telefone');

            $userModel = new UserModel();
            $userModel->createUser($username, $email, $password, $telefone);

            header("Location: /login");
            exit();
        }

        return $this->view('user/register');
    }
}
