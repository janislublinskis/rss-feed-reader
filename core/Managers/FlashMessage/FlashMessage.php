<?php

namespace Core\Managers\FlashMessage;

class FlashMessage
{
    public static function instance(): FlashMessageInterface
    {
        return new SessionFlashMessage();
    }
}