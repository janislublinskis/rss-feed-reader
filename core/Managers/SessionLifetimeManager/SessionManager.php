<?php

namespace Core\Managers\SessionLifetimeManager;

class SessionManager
{

    public static function get()
    {
        return new SessionLifetimeManager(time());
    }

}


