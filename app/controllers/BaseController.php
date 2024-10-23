<?php

namespace app\controllers;

use Exception;
use League\Plates\Engine;

abstract class BaseController
{
    protected function view(string $view, array $data = [])
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("A view {$view} não existe no caminho: {$viewPath}");
        }

        $templates = new \League\Plates\Engine(__DIR__ . '/../views');

        echo $templates->render($view, $data);
    }
}
