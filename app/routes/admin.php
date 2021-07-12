<?php

use App\Http\Response;
use App\Controller;

$router->get('/admin', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\Admin::getAdminPanel('Admin', '', 'home'));
    }
]);

$router->get('/admin/login', [
    'middlewares' => ['admin-logout'],
    function($request) {
        return new Response(200, Controller\Admin::getAdminLogin($request));
    }
]);

$router->post('/admin/login', [
    'middlewares' => ['admin-logout'],
    function($request) {
        return new Response(200, Controller\Admin::setAdminLogin($request));
    }
]);

$router->get('/admin/logout', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Controller\Admin::setAdminLogout($request));
    }
]);