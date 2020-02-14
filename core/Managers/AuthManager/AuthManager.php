<?php

namespace Core\Managers\AuthManager;

class AuthManager
{
    public static function instance(): AuthManagerInterface
    {
        return new SessionAuthManager();
    }
}