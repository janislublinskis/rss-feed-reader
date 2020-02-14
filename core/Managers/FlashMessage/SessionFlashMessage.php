<?php

namespace Core\Managers\FlashMessage;

class SessionFlashMessage implements FlashMessageInterface
{

    public function set(string $message): void
    {
        $_SESSION['_flashMessage'] = $message;
    }

    public function get(): ?string
    {
        return $_SESSION['_flashMessage'] ?? null;
    }

    public function clear(): void
    {
        unset($_SESSION['_flashMessage']);
    }
}