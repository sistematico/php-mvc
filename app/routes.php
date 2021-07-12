<?php

use App\Http\Response;
use App\Controller;

$router->get('/404', [
    function($request) {
        return new Response(200, Controller\Pages::error($request));
    }
]);

$router->get('/', [
    function($request) {
        return new Response(200, Controller\Posts::getPosts($request));
    }
]);

$router->get('/admin', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\Admin::getAdminPanel('Admin', '', 'home'));
    }
]);

$router->get('/admin/login', [
    'middlewares' => ['admin-logout'],
    function($request) {
        return new Response(200, Controller\User::getAdminLogin($request));
    }
]);

$router->post('/admin/login', [
    function($request) {
        return new Response(200, Controller\User::setAdminLogin($request));
    }
]);

$router->get('/admin/logout', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\User::setAdminLogout($request));
    }
]);

$router->get('/posts/new', [
    function($request) {
        return new Response(200, Controller\Posts::getPost($request));
    }
]);

$router->post('/posts/new', [
    function($request) {
        return new Response(200, Controller\Posts::setPost($request));
    }
]);