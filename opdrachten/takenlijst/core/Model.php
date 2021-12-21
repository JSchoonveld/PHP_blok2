<?php

namespace core;

use core\Query;

abstract class Model
{
    protected $attributes;
    protected $relations = array();

    /**
     * @param mixed $attributes
     */
    public function setAttributes($input): void
    {
        foreach ($input as $name => $value)
        {
            $this->$name = $value;	# dit is de magic-setter call
        }
    }
    public function setRelations($relations): void
    {
        $this->$relations = $relations;
    }

    /**
     * Model constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes ?: [];
    }

    public static function find($id)
    {
        return self::query()->where('id', $id)->one();

    }
    public static function findOrFail($id)
    {
        if(!self::query()->where('id', $id)->one()){
            http_response_code(404);
            die();
        }

        return self::query()->where('id', $id)->one();
    }

    public static function index()
    {
        return self::query()->all();

    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        } else {
            return $this->attributes[$name] ?? null;
        }

    }
    public function __set($name, $value)
    {
        if($value === null) {
            $this->attributes[$name] = null;
        } elseif(in_array($name, get_called_class()::INTEGERS)) {
            $this->attributes[$name] = intval($value);
        } else {
            $this->attributes[$name] = $value;
        }

    }

    public static function query()
    {
        $class = get_called_class();
        return new Query($class);

    }

    public function delete()
    {
        $query = new Query(get_called_class());
        $count = $query->where('id', $this->id)->delete();
        return $count == 1;
    }

    public function store()
    {
        $query = new Query(get_called_class());

        $this->id = $query->insert($this->attributes);

        return $this->id;
    }

}
