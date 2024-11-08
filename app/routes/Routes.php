<?php

namespace app\routes;

use app\controllers\site\AgendamentoController;
use app\controllers\site\UserController;

class Routes
{
    public static function get()
    {
        return [
            'get' => [
                '/' => 'site\HomeController@show',
                '/product' => 'site\ProductController@index',
                '/product/filter' => 'site\ProductController@filterByCategoryJson',
                '/product/search' => 'site\ProductController@searchJson',
                '/product/[0-9]+' => 'site\ProductController@show',

                '/agendamentos/create' => 'site\AgendamentoController@create',
                '/agendamentos/cancelar/[0-9]+' => 'site\AgendamentoController@cancelForm',
                '/user/edit' => 'site\UserController@editProfile',
                '/vis_agen' => 'site\AgendamentoController@vis_agen',

                '/login' => 'site\UserController@login',
                '/register' => 'site\UserController@register',
                '/services' => 'site\ServiceController@show',
                '/vcart' => 'site\CartController@vcart',

                '/admin/agendamentos/edit/[0-9]+' => 'admin\AdminAgendamentoController@edit',
                '/admin/agendamentos' => 'admin\AdminAgendamentoController@show',
                '/admin' => 'admin\AdminController@show',
                '/admin/products' => 'admin\AdminProductController@index',
                '/admin/products/create' => 'admin\AdminProductController@create',
                '/admin/products/edit/[0-9]+' => 'admin\AdminProductController@edit',

                '/checkout' => 'site\CheckoutController@show',
            ],
            'post' => [
                '/agendamentos/store' => 'site\AgendamentoController@store',
                '/agendamentos/cancelar/confirmar/[0-9]+' => 'site\AgendamentoController@confirmCancel',

                '/login' => 'site\UserController@login',
                '/register' => 'site\UserController@register',

                '/admin/agendamentos/update/[0-9]+' => 'admin\AdminAgendamentoController@update',

                '/admin/products/store' => 'admin\AdminProductController@store',
                '/admin/products/update/[0-9]+' => 'admin\AdminProductController@update',
                '/admin/products/delete/[0-9]+' => 'admin\AdminProductController@delete',

                '/checkout/process' => 'site\CheckoutController@processPayment',

                '/cart/add' => 'site\CartController@addToCart',
                '/cart/remove' => 'site\CartController@removeFromCart',

                '/update-profile' => 'site\UserController@updateProfile',

                '/logout' => 'site\UserController@logout', 
            ],
        ];
    }
}
