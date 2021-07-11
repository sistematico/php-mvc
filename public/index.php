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
    function() {
        return new Response(200, Pages::home());
    }
]);

$router->get('/posts', [
    function() {
        return new Response(200, Posts::getPosts());
    }
]);

$router->post('/posts', [
    function() {
        return new Response(200, Posts::posts());
    }
]);


$router->dispatch()->sendResponse();