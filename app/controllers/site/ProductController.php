<?php

namespace app\controllers;

use app\controllers\ContainerController;

class ProductController extends ContainerController
{
    public function index()
    {
        dd('index');
    }

    public function show($request) {}
}
