<?php

namespace core;

use app\routes\Routes;
use app\shared\support\RequestType;
use app\shared\support\Uri;

class Parameters
{
    private function filterParams(string $router)
    {
        $uri = Uri::getUri();
        $explodeUri = explode('/', $uri);
        $explodeRouter = explode('/', $router);

        $params = [];
        foreach ($explodeRouter as $index => $routerSegment) {
            if ($routerSegment !== $explodeUri[$index]) {
                $params[$index] = $explodeUri[$index];
            }
        }

        return $params;
    }

    public function get(string $router)
    {
        $routes = Routes::get();
        $requestMethod = RequestType::get();

        $router = array_search($router, $routes[$requestMethod]);

        $params = $this->filterParams($router);

        return array_values($params);
    }
}
