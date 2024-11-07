<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\database\models\UserModel;
use core\Request;

class UserController extends BaseController
{
    public function login()
    {
        session_start();

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
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = Request::input('username');
            $email = Request::input('email');
            $password = password_hash(Request::input('password'), PASSWORD_DEFAULT);
            $phone = Request::input('phone');

            $userModel = new UserModel();
            $userModel->createUser($username, $email, $password, $phone);

            header("Location: /login");
            exit();
        }

        return $this->view('user/register');
    }

    public function editProfile()
    {
        session_start();

        $id = $_SESSION['user_id'] ?? null;

        if (!$id) {
            header("Location: /login?message=login_required");
            exit();
        }

        $userModel = new UserModel();
        $user = $userModel->getUserById($id);

        if (!$user) {
            header("Location: /login?message=user_not_found");
            exit();
        }

        return $this->view('user-edit', ['user' => $user]);
    }

    public function updateProfile()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $data = [
                'username' => Request::input('username'),
                'email' => Request::input('email'),
                'phone' => Request::input('phone'),
                'city' => Request::input('city'),
                'state' => Request::input('state'),
                'street' => Request::input('street'),
                'number' => Request::input('number'),
                'postal_code' => Request::input('postal_code'),
                'complement' => Request::input('complement'),
            ];

            $userModel = new UserModel();
            $userModel->updateUser($userId, $data);

            header("Location: /profile");
            exit();
        }
    }
}
