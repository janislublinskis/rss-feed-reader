<?php

namespace Core\Managers\SessionLifetimeManager;

class SessionLifetimeManager implements SessionLifetimeManagerInterface
{
    /**
     * @var int
     */
    private $currentTime;

    /**
     * @var int
     */
    private $lifetime;

    public function __construct(int $currentTime)
    {
        $this->currentTime = $currentTime;
        $this->lifetime = config('app.session_lifetime');
    }

    public function update(): void
    {
        $_SESSION['__lifetime'] = time();
    }

    public function hasExpired(): bool
    {
        $activeSessionTime = $_SESSION['__lifetime'] ?? null;

        if (! $activeSessionTime) {
            return true;
        }

        return ($this->currentTime - $activeSessionTime) > $this->lifetime;
    }

    public function invalidate(): void
    {
        auth()->logout();
    }
}
