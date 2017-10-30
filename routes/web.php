<?php

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


$router->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function () use ($router) {

    /*
    $router->get('/', function ()    {
        // Uses Auth Middleware
    });

    $router->get('user/profile', function () {
        // Uses Auth Middleware
    });*/


    //$router->get('user_','User_Controller@index');



    $router->get('user_', function () {
        $res = new App\Http\Controllers\User_Controller();
        $res->index();
        return $res->index();
    });


    $router->get('user_/{email}', function ($email) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_byEmail($email);
    });


});













