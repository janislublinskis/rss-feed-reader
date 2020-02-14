<?php

namespace Core;

use Medoo\Medoo;

class Database
{
    private $connection;

    public static $instance;

    public function __construct(
        string $host,
        string $username,
        string $password,
        string $database
    )
    {
        $this->connection = new Medoo([
            'database_type' => 'mysql',
            'database_name' => $database,
            'server' => $host,
            'username' => $username,
            'password' => $password
        ]);

        self::$instance = $this;
    }

    public function connection()
    {
        return $this->connection;
    }
}