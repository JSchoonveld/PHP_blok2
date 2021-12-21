<?php

namespace core;

abstract class Controller
{
    protected $response;
    protected $request;
    protected $validator;

    public function __construct()
    {
        $this->response = new Response([]);
        $this->request = Request::getInstance();
        $this->validator = new Validator;

    }

}
