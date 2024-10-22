<?php
namespace app\controllers\site;

use app\database\models\User;
use app\controllers\ContainerController;

class CartController extends ContainerController{
   
    public function vcart(){
        $this->view('vcart', [
            'title' => 'carrinho de compras do petshop'
        ]);
        
    } 
}