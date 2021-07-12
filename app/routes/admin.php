<?php

use App\Http\Response;
use App\Controller;

$router->get('/admin', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\Admin::getPanel('Admin', '', 'home'));
    }
]);

$router->get('/admin/login', [
    'middlewares' => ['admin-logout'],
    function($request) {
        return new Response(200, Controller\Admin::getLogin($request));
    }
]);

$router->post('/admin/login', [
    'middlewares' => ['admin-logout'],
    function($request) {
        return new Response(200, Controller\Admin::setLogin($request));
    }
]);

$router->get('/admin/logout', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\Admin::setLogout($request));
    }
]);

$router->get('/admin/posts', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\Admin::getPanel('Admin', '', 'home'));
    }
]);

$router->get('/admin/users', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\Admin::getPanel('Admin', '', 'home'));
    }
]);