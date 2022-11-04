<?php

namespace Controller;

use PDO;

class ConnectionClass {
    private $host = "localhost";
    private $dbName = "pokemon";
    private $dbPort = "3306";
    private $dbUser = "root";
    private $dbPassword = "";

    protected $connection;

    function __construct()
    {
        $strConn = "mysql:host=" . $this->host 
        . ";dbname=" . $this->dbName 
        . ";port=" . $this->dbPort;

        $pdoOptions = [
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        ];

        $this->connection = new PDO($strConn, $this->dbUser, $this->dbPassword, $pdoOptions);
    }

}