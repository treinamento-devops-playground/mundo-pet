<?php

namespace app\routes;


class Routes
{
    public static function get()
    {
        return [
            'get' => [
                '/' => 'site\HomeController@index',
                '/product' => 'site\ProductController@index',
                '/product/[0-9]+' => 'site\ProductController@show',
                '/agendamentos/create' => 'site\AgendamentoController@create',
            ],
            'post' => [
                '/agendamentos/store' => 'site\AgendamentoController@store',
            ],
        ];
    }
}
