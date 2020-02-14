<?php
namespace Core\Managers\ErrorsManager;

interface ErrorsManagerInterface
{
    public function add(string $name, string $message);
    public function has(string $name);
    public function get(string $name): string;
    public function any(): bool;
    public function clear(): void;
}