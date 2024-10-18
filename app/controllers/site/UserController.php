<?php

namespace app\controllers;

use app\controllers\ContainerController;
use League\Plates\Engine;

class UserController extends ContainerController
{
    public function edit($request)
    {
        $templates = new Engine('../app/views');
    }
}
