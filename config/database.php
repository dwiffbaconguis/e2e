<?php

class Database
{
    public $connection;
    private $DATABASE_HOST = 'localhost';
    private $DATABASE_USERNAME = 'root';
    private $DATABASE_PASSWORD = '';
    private $DATABASE_NAME = 'e2e';

    public function getConnection()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host={$this->DATABASE_HOST}; dbname={$this->DATABASE_NAME}", $this->DATABASE_USERNAME, $this->DATABASE_PASSWORD);
        } catch (PDOException $exception) {
            echo "Connection error: {$exception->getMessage()}";
        }

        return $this->connection;
    }
}