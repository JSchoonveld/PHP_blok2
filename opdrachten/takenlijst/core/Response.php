<?php

namespace core;

use core\Session;

class Response
{
    const TEMPLATE_PATH = '../views/';
    private $variables = [];

    public function __construct($variables)
    {
        $this->variables = $variables;
    }

    public function redirect($url)
    {
        Session::getInstance()->set('_flash', $this->variables);

        header('Location: ' .$url);
        die();
    }

    public function show($template)
    {
        extract($this->variables, EXTR_SKIP);

        extract(Session::getInstance()->getAndRemove('_flash') ?? []);

        require(self::TEMPLATE_PATH . $template . '.template.php');
    }

    public function with($key, $value)
    {
        $this->variables[$key] = $value;

        return $this;
    }

    public function __set($key, $value)
    {
        $this->variables[$key] = $value;
    }
}
