<?php

include __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', config('app.debug'));

session_start();

use Core\Database;
use Core\Managers\FlashMessage\FlashMessage;
use Core\Managers\ErrorsManager\ErrorsManager;
use Core\Managers\InputManager\InputManager;
use Core\Managers\SessionLifetimeManager\SessionManager;
use App\Controllers\Auth\PasswordController;

(new Database(
    config('database.host'),
    config('database.username'),
    config('database.password'),
    config('database.database')
));

$sessionManager = SessionManager::get();
if($sessionManager->hasExpired())
{
    $sessionManager->invalidate();
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
    $namespace = "\\App\\Controllers\\";

    $router->get('/', $namespace . 'HomeController@home');
    //Login
    $router->get('/auth/login', $namespace . 'Auth\LoginController@showLoginForm');
    $router->post('/auth/login', $namespace . 'Auth\LoginController@login');
    $router->post('/auth/logout', $namespace . 'Auth\LogoutController@logout');
    //Register
    $router->get('/register', $namespace . 'RegistrationController@create');
    $router->post('/register', $namespace . 'RegistrationController@store');
    //Reset password form
    $router->get('/password_reset', $namespace . 'Auth\PasswordController@reset');
    //Reset password token set and email sent to user
    $router->post('/password_reset', $namespace . 'Auth\PasswordController@token');
    //Reset link form
    $router->get('/password_reset/{token:\w+}', $namespace . 'Auth\PasswordController@newPass');
    //Update user password with new one
    $router->put('/password_reset/{token:\w+}', $namespace . 'Auth\PasswordController@update');
});

(FlashMessage::instance());

// Fetch method and URI from somewhere
$httpMethod = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = explode('@', $handler);
        (new $controller)->$method($vars);
        break;
}

// clear flash message
if ($httpMethod === 'GET') {
    flashMessage()->clear();
    errors()->clear();
    input()->clear();
}

$sessionManager->update();
