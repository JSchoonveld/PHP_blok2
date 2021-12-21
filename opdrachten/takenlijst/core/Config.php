<?php

namespace core;

class Config
{

    private static $instance;
    private $contents;

    const PATH = __DIR__ . '/../config.ini';

    private function __construct() {
        $dbConfig    = parse_ini_file(self::PATH, true);

        $this->contents = $dbConfig;
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
    public function section($section)
    {
        return$this->contents[$section];
    }
    public function item($section,$item)
    {
        return $this->contents[$section][$item];
    }

}
