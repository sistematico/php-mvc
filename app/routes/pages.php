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
        return new Response(200, Controller\Posts::renderPosts($request));
    }
]);

// Admin
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

// Posts
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