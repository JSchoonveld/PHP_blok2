<?php

namespace core;

class Request
{
    private static $instance;

    private $url;
    private $verb;
    private $post;
    private $old;

    private function __construct()
    {
        $this->verb = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->post = $_POST ?? [];
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
    public function matches(Route $route) {
        return
            $route->verbMatches($this->verb)
            &&
            $route->urlMatches($this->url);
    }

    public function getPost()
    {
        //
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        } else {
            return trim($this->post[$name]) ?? null;
        }

    }
    public function __isset($name){
        $getter = 'get'.ucfirst($name);
        return method_exists($this, $getter) && !is_null($this->$getter());
    }
}
