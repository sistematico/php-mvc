<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Controller\Pages;

$request = new App\Http\Request;

echo '<pre>';
print_r($request);
echo '</pre>';
exit;

echo Pages::home();