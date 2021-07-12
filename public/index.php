<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('SITENAME', 'PHP MVC');
define('URL', 'https://localhost');
define('MAINTENANCE', false);

require APP . '/bootstrap.php';

$router = new Router(URL);

require APP . '/routes/main.php';

$router->dispatch()->sendResponse();