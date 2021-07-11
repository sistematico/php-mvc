<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;
use App\Controller\Pages;

$router = new Router('');

echo '<pre>';
print_r($router);
echo '</pre>';
exit;

echo Pages::home();