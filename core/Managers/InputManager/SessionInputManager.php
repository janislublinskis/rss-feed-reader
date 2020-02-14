<?php

namespace Core\Managers\InputManager;

class SessionInputManager implements InputManagerInterface
{
    public
    function save(array $input): void
    {
        $_SESSION['__input'] = $input;
    }

    public
    function get(string $key): ?string
    {
        return $_SESSION['__input'][$key] ?? null;
    }

    public
    function clear(): void
    {
        $_SESSION['__input'] = [];
    }
}