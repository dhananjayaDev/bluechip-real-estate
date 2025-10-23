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
$router->addRoute('GET', '/properties', 'PropertyController@all');
$router->addRoute('GET', '/property/{id}', 'PropertyController@show');
$router->addRoute('GET', '/admin/property/{id}', 'PropertyController@adminShow');
$router->addRoute('POST', '/property/{id}/request', 'PropertyController@submitRequest');
$router->addRoute('POST', '/property/{id}/request-details', 'PropertyController@requestDetails');
$router->addRoute('GET', '/login', 'AuthController@login');
$router->addRoute('POST', '/login', 'AuthController@authenticate');
$router->addRoute('GET', '/register', 'AuthController@register');
$router->addRoute('POST', '/register', 'AuthController@store');
$router->addRoute('POST', '/logout', 'AuthController@logout');
$router->addRoute('POST', '/property/{id}/favorite', 'PropertyController@toggleFavorite');
$router->addRoute('POST', '/contact', 'ContactController@submit');
$router->addRoute('GET', '/contact/check-auth', 'ContactController@checkAuth');

// Admin routes
$router->addRoute('GET', '/admin/login', 'AdminController@login');
$router->addRoute('POST', '/admin/login', 'AdminController@authenticate');
$router->addRoute('POST', '/admin/logout', 'AdminController@logout');
$router->addRoute('GET', '/admin', 'AdminController@index');
$router->addRoute('GET', '/admin/properties', 'AdminController@properties');
$router->addRoute('GET', '/admin/properties/add', 'AdminController@addProperty');
$router->addRoute('POST', '/admin/properties/store', 'AdminController@storeProperty');
$router->addRoute('GET', '/admin/properties/{id}', 'AdminController@propertyDetail');
$router->addRoute('GET', '/admin/properties/{id}/edit', 'AdminController@editProperty');
$router->addRoute('POST', '/admin/properties/{id}/update', 'AdminController@updateProperty');
$router->addRoute('POST', '/admin/properties/{id}/delete', 'AdminController@deleteProperty');
$router->addRoute('POST', '/admin/properties/{id}/toggle-status', 'AdminController@togglePropertyStatus');
$router->addRoute('POST', '/admin/properties/{id}/toggle-featured', 'AdminController@toggleFeatured');
$router->addRoute('POST', '/admin/properties/{id}/update-primary-image', 'AdminController@updatePrimaryImage');
$router->addRoute('POST', '/admin/properties/{id}/delete-image', 'AdminController@deletePropertyImage');
$router->addRoute('POST', '/admin/properties/bulk-action', 'AdminController@bulkAction');
$router->addRoute('GET', '/admin/users', 'AdminController@users');
$router->addRoute('POST', '/admin/users/{id}/ban', 'AdminController@banUser');
$router->addRoute('POST', '/admin/users/{id}/unban', 'AdminController@unbanUser');
$router->addRoute('POST', '/admin/users/{id}/delete', 'AdminController@deleteUser');
$router->addRoute('GET', '/admin/requests', 'AdminController@requests');
$router->addRoute('GET', '/admin/requests/{id}/details', 'AdminController@getRequestDetails');
$router->addRoute('POST', '/admin/requests/{id}/update-status', 'AdminController@updateRequestStatus');

$router->dispatch();