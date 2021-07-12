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