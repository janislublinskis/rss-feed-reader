<?php
namespace Core\Managers\AuthManager;

use App\Models\User;

interface AuthManagerInterface
{
    public function user(): User;

    public function check(): bool;

    public function loginById(int $id): void;

    public function getAuthenticatedUser(): void;

    public function logout(): void;

}