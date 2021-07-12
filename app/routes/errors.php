<?php

use App\Http\Response;
use App\Controller;

$router->get('/404', [
    function($request) {
        return new Response(200, Controller\Pages::notFound($request));
    }
]);

$router->get('/405', [
    function($request) {
        return new Response(200, Controller\Pages::notAllowed($request));
    }
]);