<?php

use App\Http\Response;
use App\Controller;

$router->get('/users/login', [
    'middlewares' => ['user-logout'],
    function($request) {
        return new Response(200, Controller\User::getUserLogin($request));
    }
]);

$router->post('/users/login', [
    'middlewares' => ['user-logout'],
    function($request) {
        return new Response(200, Controller\User::setUserLogin($request));
    }
]);

$router->get('/users/signup', [
    'middlewares' => ['user-logout'],
    function($request) {
        return new Response(200, Controller\User::getUserSignup($request));
    }
]);

$router->post('/users/signup', [
    'middlewares' => ['user-logout'],
    function($request) {
        return new Response(200, Controller\User::setUserSignup($request));
    }
]);

$router->get('/users/logout', [
    'middlewares' => ['user-login'],
    function($request) {
        return new Response(200, Controller\User::setUserLogout($request));
    }
]);