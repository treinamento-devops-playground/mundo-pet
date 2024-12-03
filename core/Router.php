<?php

namespace core;

use app\routes\Routes;

class Router
{
    public static function run($container)
    {
        try {
            $routerRegistered = new RoutersFilter;
            $router = $routerRegistered->get();

            $controller = new Controller($container);
            $controller->execute($router);

            // dd($router);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
