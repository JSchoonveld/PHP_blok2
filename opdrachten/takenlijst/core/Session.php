<?php

namespace core;

class Session
{
    private static $instance;

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            session_start();
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set($key, $variables)
    {

        $_SESSION[$key] = $variables;
    }

    public function getAndRemove($key)
    {
        $session_variable = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $session_variable;
    }
}
