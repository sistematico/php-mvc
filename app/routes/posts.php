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

$router->get('/posts/{id}/edit', [
    'middlewares' => ['user-login'],
    function($request, $id) {
        return new Response(200, Controller\Posts::getEditPost($request, $id));
    }
]);

$router->post('/posts/{id}/edit', [
    'middlewares' => ['user-login'],
    function($request, $id) {
        return new Response(200, Controller\Posts::setEditPost($request, $id));
    }
]);