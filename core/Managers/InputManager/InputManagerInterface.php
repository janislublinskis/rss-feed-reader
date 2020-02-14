<?php

namespace Core\Managers\InputManager;

interface InputManagerInterface
{
    public function save(array $input): void;

    public function get(string $key): ?string;

    public function clear(): void;

}