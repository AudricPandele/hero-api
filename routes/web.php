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

// Heros routes
$router->post('/auth/login/', 'UsersController@authenticate');
$router->post('/auth/register/', 'UsersController@register');
$router->get('users/{id}', 'UsersController@detail');
$router->get('heros', 'HeroController@show');
$router->get('heros/home', 'HeroController@home');
$router->get('heros/{id}', 'HeroController@detail');
$router->post('heros', 'HeroController@search');
