<?php

namespace app\controllers\site;

use app\controllers\ContainerController;
use League\Plates\Engine;

class HomeController extends ContainerController
{
    public function show()
    {
        $this->view('home', ['title' => 'home - Mundo Pet']);
    }
}
