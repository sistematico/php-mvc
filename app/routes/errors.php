<?php

use App\Http\Response;
use App\Controller;

$router->get('/404', [
    function($request) {
        return new Response(200, Controller\Pages::error(404, 'Not Found'));
    }
]);

$router->get('/405', [
    function($request) {
        return new Response(200, Controller\Pages::error(405, 'Not Allowed'));
    }
]);