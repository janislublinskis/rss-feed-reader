<?php

namespace Core\Managers\FlashMessage;

interface FlashMessageInterface
{

    public function set(string $message): void;

    public function get(): ?string;

    public function clear(): void;

}
