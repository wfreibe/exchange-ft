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
    $router->get('users', function () {
        $res = new App\Http\Controllers\User_Controller();
        $res->index();
        return $res->index();
    });*/

    $router->get('users', ['middleware' => 'auth', function () {
        $res = new App\Http\Controllers\User_Controller();
        return $res->index();
    }]);

    $router->post('users', ['middleware' => 'auth', function (Illuminate\Http\Request $request) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->createUser_($request);
    }]);

    $router->put('users/{userId}', ['middleware' => 'auth', function ($userId, Illuminate\Http\Request $request) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->updateUser_($userId, $request);
    }]);

    $router->get('users/email/{email}', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_ByEmail($email);
    }]);

    $router->get('users/{email}/check', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\User_Controller();
        if(empty($res->getUser_ByEmail($email)->original[0]["emailAddress"])) {
            return "false";
        } else {
            return "true";
        }
    }]);

    $router->get('organizations/{orgId}/users', ['middleware' => 'auth', function ($orgId) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getOrganizationUsersByOrgId($orgId);
    }]);

    $router->get('organizations/first/users/{userId}', ['middleware' => 'auth', function ($userId) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getFirstOrganizationUsers($userId);
    }]);

    $router->get('organizations/first/users/email/{email}', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getFirstOrganizationUsersByEmail($email);
    }]);

    $router->get('users/{userId}', ['middleware' => 'auth', function ($userId) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_ByUserId($userId)->original[0];
    }]);

    $router->delete('users/{userId}', ['middleware' => 'auth', function ($userId) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->deleteUser_($userId);
    }]);

    $router->get('users/search/{searchString}', ['middleware' => 'auth', function ($searchString) {
        $res = new App\Http\Controllers\User_Controller();
        return $res->getUser_BySearchString($searchString);
    }]);

    $router->get('users/{email}/organizations', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\OrganizationController();
        return $res->getUserOrganizationsByEmail($email);
    }]);

    $router->get('users/{email}/organizations/first', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\OrganizationController();
        return $res->getFirstUserOrganizationByEmail($email);
    }]);

    $router->get('users/{email}/organizations/{frdlurl}/projects', ['middleware' => 'auth', function ($email, $frdlurl) {
        $res = new App\Http\Controllers\GroupController();
        return $res->getUserOrganizationProjectsByEmailAndFriendlyUrl($email, $frdlurl);
    }]);

    $router->get('users/{email}/organizations/projects/first', ['middleware' => 'auth', function ($email) {
        $res = new App\Http\Controllers\GroupController();
        return $res->getFistUserOrganizationProjectsByEmailAndFriendlyUrl($email);
    }]);

});

// for auth see: https://lumen.laravel.com/docs/5.5/middleware
// tutorial for oauth0: https://code.tutsplus.com/tutorials/how-to-secure-a-rest-api-with-lumen--cms-27442
