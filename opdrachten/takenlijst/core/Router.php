<?php

namespace core;

class Router
{
    private static $instance; // Router object
    private $active_route;
    private $configured_routes;
    private static $webroot;

    private function __construct() {
        // Constructor code
    }
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function go() {
        $route = $this->getActiveRoute();

        if(!$route){
            http_response_code(404);
        } else {
            $route->deploy();
        }
    }
    public function getActiveRoute(): Route|Bool{
        if(!isset($this->active_route)) {
            $this->active_route = false;
            foreach($this->getConfiguredRoutes() as $route) {
                if(Request::getInstance()->matches($route)){{
                    $this->active_route = $route;
                    break;
                }}
            }
        }
        return $this->active_route;
    }
    public function getConfiguredRoutes(): Array
    {
        if (!isset($this->configured_routes)) {
            include '../config/routes.php';
        }

        return $this->configured_routes ?? [];
    }

    public static function getWebroot() {

        if(dirname($_SERVER['SCRIPT_NAME']) == DIRECTORY_SEPARATOR) {
            self::$webroot = '';
        } else {
            self::$webroot = dirname($_SERVER['SCRIPT_NAME']);
        }
        return self::$webroot;
    }

}
