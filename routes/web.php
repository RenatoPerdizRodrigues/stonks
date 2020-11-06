<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * App Routes
 */
$router->group(['prefix' => 'api'], function () use ($router){
    /**
     * Stock routes
     */
    $router->post('stocks/store', 'StockController@store');
    $router->put('stocks/{id}/update', 'StockController@update');

    /**
     * Operation routes
     */
    $router->post('operations/store', 'OperationController@store');
});