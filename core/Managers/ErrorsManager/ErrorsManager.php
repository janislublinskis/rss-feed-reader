<?php
namespace Core\Managers\ErrorsManager;

class ErrorsManager
{
    public static function instance(): ErrorsManagerInterface
    {
        return new SessionErrorsManager();
    }
}