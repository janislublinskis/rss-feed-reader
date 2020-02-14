<?php

namespace Core\Managers\InputManager;

class InputManager
{
    public static function instance(): InputManagerInterface
    {
        return new SessionInputManager();
    }
}

