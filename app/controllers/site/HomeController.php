<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use League\Plates\Engine;

class HomeController extends BaseController
{
    public function show()
    {
        $this->view('home', ['title' => 'home - Mundo Pet']);
    }
}
