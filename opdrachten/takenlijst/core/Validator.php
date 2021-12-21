<?php

namespace core;

class Validator
{

    private static $instance;
    private $rules;
    private $errors = [];

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
    public function withRules($rules)
    {
        $this->rules= $rules;
        return $this;
    }

    public function rejects(Request $request)
    {
        foreach($this->rules as $field => $rules_per_field)
        {
            foreach($rules_per_field as $rule)
            {
                $this->check($field, $request->$field, $rule);
            }
        }
        return count($this->errors) != 0;
    }

    private function check($field, $value, $rule)
    {
        $rule = explode(':', $rule);
        $rule_method = $rule[0];
        $parameters = [$field, $value];

        if(isset($rule[1]))
        {
            $parameters[] = $rule[1];
        }
        call_user_func_array([$this, $rule_method], $parameters);
    }

    private function unique($field, $value, $class)
    {
        if($class::query()->where($field, $value)->one())
        {
            $this->errors[$field] = 'the ' . $field . ' may not already exist.';
        }
    }
    private function required($field, $value)
    {
        if(empty($value))
        {
            $this->errors[$field] = $field . ' is required.';
        }
    }

    private function max($field, $value, $max)
    {
        if(strlen($value) > $max)
        {
            $this->errors[$field] = $field . ' cannot be more than ' . $max . ' characters.';
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
