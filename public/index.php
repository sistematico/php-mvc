<?php


require dirname(__DIR__) . '/vendor/autoload.php';

use App\Http\Router;

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('SITENAME', 'PHP MVC');
define('URL', 'https://localhost');
define('MAINTENANCE', false);

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

echo '<pre>';
print_r($actual_link);
echo '</pre>';
exit;

echo '<pre>';
print_r(URL);
echo '</pre>';
exit;

require APP . '/bootstrap.php';

$router = new Router(URL);

require APP . '/routes/main.php';

$router->dispatch()->sendResponse();