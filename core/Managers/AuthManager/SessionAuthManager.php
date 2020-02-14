<?php
namespace Core\Managers\AuthManager;

use App\Models\User;
use InvalidArgumentException;

class SessionAuthManager implements AuthManagerInterface
{
    public static $instance;

    /**
     * @var User
     */
    private $user;

    public function __construct()
    {
        self::$instance = $this;

        $this->getAuthenticatedUser();
    }

    public function user(): User
    {
        if ($this->user === null) {
            throw new InvalidArgumentException('User not authenticated.');
        }

        return $this->user;
    }

    public function check(): bool
    {
        return $this->user !== null;
    }

    public function loginById(int $id): void
    {
        $_SESSION['authentication_key'] = $id;
    }

    public function getAuthenticatedUser(): void
    {
        $user = database()->get('users', '*', [
            'id' => $_SESSION['authentication_key'] ?? null
        ]);

        $this->user = !empty($user) ? User::create($user) : null;
    }

    public function logout(): void
    {
        $this->user = null;
        unset($_SESSION['authentication_key']);
    }
}