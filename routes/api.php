<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return "API is working.";
    });

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/stock', 'StockController@fetchAll');
        $router->post('/stock','StockController@create');
    });

});
