<?php

namespace app\routes;


class Routes
{
    public static function get()
    {
        return [
            'get' => [
                '/' => 'site\HomeController@show',
                '/product' => 'site\ProductController@index',
                '/product/[0-9]+' => 'site\ProductController@show',
                '/agendamentos/create' => 'site\AgendamentoController@create',
                '/login' => 'site\UserController@login',
                '/register' => 'site\UserController@register',
                '/services' => 'site\ServiceController@show'
            ],
            'post' => [
                '/agendamentos/store' => 'site\AgendamentoController@store',
                '/login' => 'site\UserController@login',
                '/register' => 'site\UserController@register'
            ],
        ];
    }
}
