<?php

namespace app\controllers\site;

use app\database\models\User;
use app\controllers\BaseController;

class CartController extends BaseController
{

    public function vcart()
    {
        $this->view('vcart', [
            'title' => 'carrinho de compras do petshop'
        ]);
    }
}
