<?php

use Pimple\Container;

$container = new Container();

$container['IAgendamentoRepository'] = function ($c) {
    return new \app\database\repositories\AgendamentoRepository();
};

$container['IAdminAgendamentoService'] = function ($c) {
    return new \app\services\AdminAgendamentoService($c['IAgendamentoRepository']);
};

$container['IAgendamentoService'] = function ($c) {
    return new \app\services\AgendamentoService($c['IAgendamentoRepository']);
};

$container['app\controllers\admin\AdminAgendamentoController'] = function ($c) {
    return new \app\controllers\admin\AdminAgendamentoController($c['IAdminAgendamentoService']);
};

$container['app\controllers\site\AgendamentoController'] = function ($c) {
    return new \app\controllers\site\AgendamentoController($c['IAgendamentoService']);
};

return $container;
