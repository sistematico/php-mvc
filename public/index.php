<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;
use App\Http\Response;
use App\Controller\Pages;
use App\Controller\Posts;
use App\Core\View;

define('SITENAME', 'PHP MVC');
define('URL', 'https://localhost');

View::init([
    'SITENAME'=>SITENAME,
    'URL'=>URL,
    'YEAR'=> date('Y')
]);

$router = new Router(URL);

$router->get('/', [
    function($request) {
        return new Response(200, Posts::getPosts($request));
    }
]);

$router->get('/posts', [
    function($request) {
        return new Response(200, Posts::getPost($request));
    }
]);

$router->post('/posts', [
    function($request) {
        return new Response(200, Posts::setPost($request));
    }
]);


$router->dispatch()->sendResponse();