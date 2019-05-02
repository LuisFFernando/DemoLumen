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


$router->post('/user/login', ['uses' => 'UsersController@getToken']);

//$router->get('/', function () use ($router) {
//    return $router->app->version();
//});
//Recurso para generar el APP_KEY
$router->get('/key', function () {
    return str_random(32);
});

//Rutas protegidas
$router->group(['middleware' => ['auth']], function ( ) use ($router) {
        $router->get('/Users', ['uses' => 'UsersController@Index']);
        $router->post('/Users', ['uses' => 'UsersController@create']);
        $router->get('/Users/{id}', ['uses' => 'UsersController@findId']);
        $router->put('/Users/{id}', ['uses' => 'UsersController@update']);
        $router->delete('/Users/{id}', ['uses' => 'UsersController@delete']);
});



