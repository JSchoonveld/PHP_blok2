<?php

namespace core;

class Route
{
    private $verb;
    private $url_regex;
    private $controller;
    private $method;
    private $parameters;

    public function __construct($verb, $url_regex, $controller, $method)
    {
        $this->verb = $verb;
        $this->url_regex = $url_regex;
        $this->controller = $controller;
        $this->method = $method;
    }

    public function verbMatches($verb)
    {
        return $verb == $this->verb;
    }

    public function urlMatches($url)
    {
        $pattern = '#^' . Router::getWebroot() . $this->url_regex . '$#';

        $pregMatch = preg_match($pattern, $url, $matches);

        if($pregMatch) {
            $this->parameters = array_slice($matches, 1);
        }

        return $pregMatch;
    }

    public function deploy()
    {
        return call_user_func_array([new $this->controller, $this->method], $this->parameters);
    }
}
