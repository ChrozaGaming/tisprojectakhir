<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Product routes
$router->group(['prefix' => 'api/products'], function () use ($router) {
    $router->get('/', 'ProductController@index');
    $router->post('/', 'ProductController@store');
    $router->get('/{id}', 'ProductController@show');
    $router->put('/{id}', 'ProductController@update');
    $router->patch('/{id}/stock', 'ProductController@updateStock');
    $router->delete('/{id}', 'ProductController@destroy');
});

// Order routes
$router->group(['prefix' => 'api/orders'], function () use ($router) {
    $router->get('/', 'OrderController@index');
    $router->post('/', 'OrderController@store');
    $router->get('/{id}', 'OrderController@show');
    $router->patch('/{id}/status', 'OrderController@updateStatus');
});