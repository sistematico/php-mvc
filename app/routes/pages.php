<?php

use App\Http\Response;
use App\Controller;

$router->get('/', [
    function($request) {
        return new Response(200, Controller\Posts::getPosts($request));
    }
]);