<?php
namespace data\base;

class Database {
    private $pdo;

    public function connect()
    {
        $dsn = 'mysql:host=localhost;dbname=blogdata';
        // Create a new PDO instance
        try {
            if ($this->pdo === null) {
                $this->pdo = new \PDO( $dsn, 'root', '' );
                $this->pdo->setAttribute( \PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8" );
                $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            }
        } // Catch any errors
        catch (\PDOException $e) {
            echo $e->getMessage();
            exit();
        }
        return $this->pdo;
    }
}