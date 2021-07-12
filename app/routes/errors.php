<?php

use App\Http\Response;
use App\Controller;

$router->get('/error/{code}', [
    function($request, $code) {
        return new Response($code, Controller\Pages::getError($code));
    }
]);