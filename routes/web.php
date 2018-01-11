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

    $router->get('users', function () {
        $res = new App\Http\Controllers\User_Controller();
        $res->index();
        return $res->index();
    });

    /*
    $router->get('users/{email}', function ($email) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_ByEmail($email);
    });
    */

    $router->get('users/email/{email}', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_ByEmail($email);
    }]);

    $router->get('users/{userId}', ['middleware' => 'auth', function ($userId) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_ByUserId($userId);
    }]);

    /*
    $router->get('users/{userId}', function ($userId) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_ByUserId($userId)->original[0];
    });
    */

    /*
    $router->get('users/{email}/organizations', function ($email) {
        $res = new App\Http\Controllers\OrganizationController();
        return $res->getUserOrganizationsByEmail($email);
    });
    */

    $router->get('users/{email}/organizations', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\OrganizationController();
        return $res->getUserOrganizationsByEmail($email);
    }]);

    /*
    $router->get('users/{email}/organizations/{orgname}/projects', function ($email, $orgname) {
        $res = new App\Http\Controllers\GroupController();
        return $res->getUserOrganizationProjectsByEmailAndOrgName($email, $orgname);
    });
    */

    $router->get('users/{email}/organizations/{orgname}/projects', ['middleware' => 'auth', function ($email, $orgname) {
        $res = new App\Http\Controllers\GroupController();
        return $res->getUserOrganizationProjectsByEmailAndOrgName($email, $orgname);
    }]);

});


// for auth see: https://lumen.laravel.com/docs/5.5/middleware
// tutorial for oauth0: https://code.tutsplus.com/tutorials/how-to-secure-a-rest-api-with-lumen--cms-27442
