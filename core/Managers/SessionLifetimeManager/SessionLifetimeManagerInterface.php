<?php

namespace Core\Managers\SessionLifetimeManager;

interface SessionLifetimeManagerInterface
{
    public function update(): void;
    public function hasExpired(): bool;
    public function invalidate(): void;
}
