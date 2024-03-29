<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/categories', 'CategoryController');
    $router->resource('market-places', 'MarketPlaceController');
    $router->resource('users', 'UserController');
    $router->resource('users-marketplace-settings', 'UserMarketSettingController');

    # Товары
    $router->resource('products', 'ProductController');
});
