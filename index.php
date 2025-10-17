<?php
session_start();

// Define constants
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Include helper functions
require_once APP_PATH . '/helpers/functions.php';

// Set up autoloader
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/models/',
        APP_PATH . '/controllers/',
        APP_PATH . '/core/',
        APP_PATH . '/helpers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Include configuration
require_once APP_PATH . '/config/database.php';
require_once APP_PATH . '/config/config.php';

// Router
$router = new Router();
$router->addRoute('GET', '/', 'PropertyController@index');
$router->addRoute('GET', '/property/{id}', 'PropertyController@show');
$router->addRoute('POST', '/property/{id}/request', 'PropertyController@requestDetails');
$router->addRoute('GET', '/login', 'AuthController@login');
$router->addRoute('POST', '/login', 'AuthController@authenticate');
$router->addRoute('GET', '/register', 'AuthController@register');
$router->addRoute('POST', '/register', 'AuthController@store');
$router->addRoute('POST', '/logout', 'AuthController@logout');
$router->addRoute('POST', '/property/{id}/favorite', 'PropertyController@toggleFavorite');

$router->dispatch();