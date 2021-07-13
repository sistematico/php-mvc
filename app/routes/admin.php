<?php

use App\Http\Response;
use App\Controller\Admin\Admin;
use App\Controller\Admin\Posts;
use App\Controller\Admin\Users;

// Home
$router->get('/admin', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Admin::getAdminPanel('Admin', '', 'home'));
    }
]);

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

// Admin Users
$router->get('/admin/users', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Users::getUsers($request));
    }
]);

$router->get('/admin/users/new', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Posts::getNewUser($request));
    }
]);

$router->post('/admin/users/new', [
    'middlewares' => ['admin-login'],
    function($request) {
        return new Response(200, Posts::setNewUser($request));
    }
]);

$router->get('/admin/users/{id}/edit', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::getEditUser($request, $id));
    }
]);

$router->post('/admin/users/{id}/edit', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::setEditUser($request, $id));
    }
]);

$router->get('/admin/users/{id}/delete', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::getDeleteUser($request, $id));
    }
]);

$router->post('/admin/users/{id}/delete', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::setDeleteUser($request, $id));
    }
]);

// Admin Posts
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

$router->get('/admin/posts/{id}/delete', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::getDeletePost($request, $id));
    }
]);

$router->post('/admin/posts/{id}/delete', [
    'middlewares' => ['admin-login'],
    function($request, $id) {
        return new Response(200, Posts::setDeletePost($request, $id));
    }
]);