<?php

use App\Http\Response;
use App\Controller\Admin\Admin;
use App\Controller\Admin\Posts;

$router->get('/admin/login', [
    'middlewares' => ['admin-logout'],
    function($request) {
        return new Response(200, Admin::getLogin($request));
    }
]);

$router->post('/admin/login', [
    'middlewares' => ['admin-logout'],
    function($request) {
        return new Response(200, Admin::setLogin($request));
    }
]);

$router->get('/admin/logout', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Admin::setLogout($request));
    }
]);

$router->get('/admin', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Admin::getAdminPanel('Admin', '', 'home'));
    }
]);

$router->get('/admin/posts', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Posts::getPosts($request));
    }
]);

$router->get('/admin/users', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Admin::getAdminPanel('Admin - Users', '', 'users'));
    }
]);