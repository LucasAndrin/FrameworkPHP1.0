<?php

namespace App\Database;

require_once 'vendor/autoload.php';

require_once 'config/database.php';

use PDO;

class PdoConnection {

    private PDO $connection;

    private $stmt;

    function __construct() 
    {
        $this->connection = new PDO(POSTGRES_DNS, DB_USER, DB_PASSWORD);
    }

    public function prepare($query)
    {
        $this->stmt = $this->connection->prepare($query);
    }

    public function bindValue(string $key, $value)
    {
        $this->stmt->bindValue(":$key", $value);
    }

    public function bindValues(array ...$params)
    {
        foreach ($params as $param) {
            foreach ($param as $key => $value) {
                $this->bindValue($key, $value);
            }
        }
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    public function fetch()
    {
        return $this->stmt->fetch(PDO::FETCH_CLASS);
    }

    public function fetchAll()
    {
        return $this->stmt->fetchAll(PDO::FETCH_CLASS);
    }

}