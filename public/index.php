<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;
use App\Http\Response;
use App\Controller\Pages;
use App\Controller\Posts;
use App\Core\View;
use App\Http\Middleware\Queue;

define('SITENAME', 'PHP MVC');
define('URL', 'https://localhost');
define('MAINTENANCE', false);

View::init([
    'SITENAME'=>SITENAME,
    'URL'=>URL,
    'YEAR'=> date('Y')
]);

Queue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class
]);
Queue::setDefault(['maintenance']);

$router = new Router(URL);

$router->get('/', [
    function($request) {
        return new Response(200, Posts::getPosts($request));
    }
]);

// $router->get('/admin', [
//     function($request) {
//         return new Response(200, Pages::getAdmin($request));
//     }
// ]);

$router->get('/admin/login', [
    function($request) {
        return new Response(200, Pages::getAdminLogin($request));
    }
]);

$router->post('/admin/login', [
    function($request) {
        return new Response(200, Pages::setAdminLogin($request));
    }
]);

$router->get('/posts/new', [
    function($request) {
        return new Response(200, Posts::getPost($request));
    }
]);

$router->post('/posts/new', [
    function($request) {
        return new Response(200, Posts::setPost($request));
    }
]);


$router->dispatch()->sendResponse();