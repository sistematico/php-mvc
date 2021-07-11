<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;
use App\Controller\Pages;

define('URL', 'https://localhost');

$router = new Router(URL);

echo '<pre>';
print_r($router);
echo '</pre>';
exit;

echo Pages::home();