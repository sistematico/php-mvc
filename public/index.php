<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;
use App\Http\Response;
use App\Controller\Pages;
use App\Core\View;

define('URL', 'https://localhost');

View::init(['URL'=>URL]);

$router = new Router(URL);

$router->get('/', [
    function() {
        return new Response(200, Pages::home());
    }
]);

$router->get('/posts', [
    function() {
        return new Response(200, Pages::posts());
    }
]);

$router->post('/posts', [
    function() {
        return new Response(200, Pages::posts());
    }
]);


$router->dispatch()->sendResponse();