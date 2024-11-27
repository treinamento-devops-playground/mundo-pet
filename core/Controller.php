<?php

namespace core;

use Pimple\Container;

use Exception;

class Controller
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function execute(string $router)
    {

        if (!str_contains($router, '@')) {
            throw new Exception("A rota está registrada com o formato errado");
        }

        list($controller, $method) = explode('@', $router);

        // dd($controller, $method);

        $namespace = "app\controllers\\";

        // dd($namespace);

        $controllerNamespace = $namespace . $controller;

        if (!class_exists($controllerNamespace)) {
            throw new Exception("O controller {$controllerNamespace} não existe");
        }

        if ($this->container->offsetExists($controllerNamespace)) {
            $controller = $this->container[$controllerNamespace];
        } else {
            $controller = new $controllerNamespace();
        }

        if (!method_exists($controller, $method)) {
            throw new Exception("O método {$method} não existe no controller {$controllerNamespace}");
        }

        $params = new Parameters;
        $params = $params->get($router);

        call_user_func_array([$controller, $method], $params);
    }
}
