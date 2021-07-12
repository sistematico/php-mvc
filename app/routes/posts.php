<?php

use App\Http\Response;
use App\Controller;

$router->get('/posts/new', [
    'middlewares' => ['user-login'],
    function($request) {
        return new Response(200, Controller\Posts::getNewPost($request));
    }
]);

$router->post('/posts/new', [
    'middlewares' => ['user-login'],
    function($request) {
        return new Response(200, Controller\Posts::setNewPost($request));
    }
]);