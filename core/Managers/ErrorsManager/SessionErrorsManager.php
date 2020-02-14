<?php
namespace Core\Managers\ErrorsManager;

class SessionErrorsManager implements ErrorsManagerInterface
{
    public static $instance;

    public function __construct()
    {
        self::$instance = $this;
    }

    public function add(string $name, string $message)
    {
        $_SESSION['_errors'][$name] [] = $message;
    }

    public function has(string $name)
    {
        if (!empty($_SESSION['_errors'][$name])) {
            return $_SESSION['_errors'][$name];
        }
    }

    public function get(string $name): string
    {
        return $_SESSION['_errors'][$name][0];
    }

    public function any(): bool
    {
        return !empty($_SESSION['_errors']);
    }

    public function clear(): void
    {
        unset($_SESSION['_errors']);
    }
}