<?php


require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('SITENAME', 'PHP MVC');
define('URL', $url);
define('MAINTENANCE', false);
define('DATABASE', ROOT . '/database/database.sqlite');

require APP . '/bootstrap.php';

$router = new Router(URL);

require APP . '/routes/main.php';

$router->dispatch()->sendResponse();