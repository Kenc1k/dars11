<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "Kenc1k06";
    private $database = "db_text";
    
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
