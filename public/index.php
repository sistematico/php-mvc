<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Controller\Pages;

$response = new App\Http\Response(200, 'Olá Mundo');

$response->sendResponse();

echo Pages::home();