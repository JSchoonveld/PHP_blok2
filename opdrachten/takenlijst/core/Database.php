<?php

namespace core;

use PDO;

class Database
{
    private static $instance;
    public $pdo;

    private function __construct()
    {
        $dbConfig = Config::getInstance();
        {
            $driver = $dbConfig->item('database','driver');
            $host = $dbConfig->item('database','host');
            $port = $dbConfig->item('database','port');
            $database = $dbConfig->item('database','database');
            $username = $dbConfig->item('database','username');
            $password = $dbConfig->item('database','password');

            $dsn = $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $database;

            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
