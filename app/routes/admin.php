<?php

use App\Http\Response;
use App\Controller\Admin\Admin;
use App\Controller\Admin\Posts;
use App\Controller\Admin\Users;

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

$router->get('/admin/users', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Users::getUsers($request));
    }
]);

$router->get('/admin/posts', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Posts::getPosts($request));
    }
]);

$router->get('/admin/posts/new', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Posts::getNewPost($request));
    }
]);

$router->post('/admin/posts/new', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Posts::setNewPost($request));
    }
]);

$router->get('/admin/posts/{id}/edit', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::getEditPost($request, $id));
    }
]);

$router->post('/admin/posts/{id}/edit', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::setEditPost($request, $id));
    }
]);