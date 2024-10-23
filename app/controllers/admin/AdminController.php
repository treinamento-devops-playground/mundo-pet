<?php

namespace app\controllers\admin;

use app\controllers\BaseController;


class AdminController extends BaseController
{
    public function show()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $this->view('admin', ['title' => 'painel administrativo']);
    }
}
