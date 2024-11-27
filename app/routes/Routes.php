<?php

namespace app\routes;

class Routes
{
    public static function get()
    {
        return [
            'get' => [
                '/' => 'site\HomeController@show',
                '/catalog' => 'site\ProductController@index',
                '/product/filter' => 'site\ProductController@filterByCategoryJson',
                '/product/search' => 'site\ProductController@searchJson',
                '/product/all' => 'site\ProductController@allProductsJson',
                '/product/[0-9]+' => 'site\ProductController@show',

                '/agendamentos/create' => 'site\AgendamentoController@create',
                '/agendamentos/cancelar/[0-9]+' => 'site\AgendamentoController@cancelForm',
                '/user/edit' => 'site\UserController@editProfile',
                '/user/agendamentos' => 'site\AgendamentoController@vis_agen',

                '/scheduling-feedback/create/[0-9]+' => 'site\SchedulingFeedbackController@create',

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
                '/admin/products/delete/[0-9]+' => 'admin\AdminProductController@delete',

                '/checkout' => 'site\CheckoutController@show',
                '/cart' => 'site\CartController@viewCart',

                // Nova rota para pegar avaliações de um produto
                '/reviews/[0-9]+' => 'site\ReviewController@getProductReviews', // GET para recuperar avaliações de um produto
            ],
            'post' => [
                '/product/review' => 'site\ReviewController@addReview', // POST para adicionar avaliação
                '/agendamentos/store' => 'site\AgendamentoController@store',
                '/agendamentos/cancelar/confirmar/[0-9]+' => 'site\AgendamentoController@confirmCancel',
                'api/scheduling-feedback/store' => 'site\SchedulingFeedbackController@store',

                '/login' => 'site\UserController@login',
                '/register' => 'site\UserController@register',

                '/admin/agendamentos/update/[0-9]+' => 'admin\AdminAgendamentoController@update',
                '/admin/products/store' => 'admin\AdminProductController@store',
                '/admin/products/update/[0-9]+' => 'admin\AdminProductController@update',
                
                '/checkout/process' => 'site\CheckoutController@processPayment',

                '/cart/add' => 'site\CartController@addToCart',
                '/cart/remove/[0-9]+' => 'site\CartController@removeFromCart',
                


                '/update-profile' => 'site\UserController@updateProfile',
                '/logout' => 'site\UserController@logout',
            ],
        ];
    }
}
