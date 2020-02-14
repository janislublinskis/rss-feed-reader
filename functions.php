<?php

use Core\Managers\AuthManager\AuthManager;
use Core\Database;
use Core\Managers\ErrorsManager\ErrorsManager;
use Core\Managers\FlashMessage\FlashMessage;
use Core\Managers\InputManager\InputManager;

function view(string $path, array $vars = [])
{
    extract($vars);

    include(__DIR__ . '/app/Views/' . $path . '.php');
}

function redirect(string $location)
{
    header('Location: ' . $location);
    exit;
}

function config(string $key, string $defaultValue = '')
{
    $defaultValue = !empty($defaultValue) ? $defaultValue : $key;
    [$fileName, $configKey] = explode('.', $key, 2);
    $config = include __DIR__ . '/config/'.$fileName.'.php';

    return $config[$configKey] ?? $defaultValue;
}

function database()
{
    return Database::$instance->connection();
}

function auth()
{
    return AuthManager::instance();
}

function flashMessage()
{
    return FlashMessage::instance();
}

function errors()
{
    return ErrorsManager::instance();
}

function input()
{
    return InputManager::instance();
}
//Token generation function
function generateNewString($len = 10) {
    $token = "poiuztrewqasdfghjklmnbvcxy1234567890";
    $token = str_shuffle($token);
    $token = substr($token, 0, $len);

    return $token;
}
