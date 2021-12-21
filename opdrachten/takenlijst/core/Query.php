<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2021
 */
namespace core;

use PDO;

class Query
{
    /**
     * naam van de child class waarvoor de query moet worden uitgevoerd
     */
    private $class;

    /**
     * array met binds, array van associatieve arrays
     * elke item is een associatieve array met drie keys: placeholder, value, type
     */
    private $binds = [];

    /**
     * string met de volledige where-clause van de query (te beginnen met WHERE, zonder leading spatie)
     */
    private $where = '';

    /**
     * constructor; leg de naam van de class vast, waarvoor een query moet worden uitgevoerd
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * method-cascading setter voor een where-conditie
     * gekoppelde where-calls resulteren in AND-ing van condities in de WHERE-clause
     */
    public function where($field, $value, $operator = '=')
    {
        $placeholder = ':p' . count($this->binds);
        $type = in_array($field, $this->class::INTEGERS ?? []) ? PDO::PARAM_INT : PDO::PARAM_STR;

        $this->where .= ($this->where ? ' AND ' : 'WHERE ') . $field . ' ' . $operator . ' ' . $placeholder;
        $this->binds[] = ['placeholder' => $placeholder, 'value' => $value, 'type' => $type];

        return $this;
    }

    private function bind($field, $value)
    {
        $placeholder = ':p' . count($this->binds);
        $type = in_array($field, $this->class::INTEGERS) ? PDO::PARAM_INT : PDO::PARAM_STR;

        $this->binds[] = ['placeholder' => $placeholder, 'value' => $value, 'type' => $type];

        return $placeholder;
    }

    /**
     * voer SELECT-query uit en retourneer het resultaat als een object van de child class
     */
    public function one()
    {
        $record = $this->executed_statement($this->selectQuery())->fetch(PDO::FETCH_ASSOC);

        if ($record)
        {
            $model = new $this->class;
            $model->setAttributes($record);
        }

        return $model ?? null;
    }

    /**
     * voer SELECT-query uit en retourneer het resultaat als een array van objecten van de child class
     */
    public function all()
    {
        $records = $this->executed_statement($this->selectQuery())->fetchAll(PDO::FETCH_ASSOC);

        $models = [];
        foreach ($records as $record)
        {
            $model = new $this->class;
            $model->setAttributes($record);
            $models[] = $model;
        }

        return $models;
    }

    /**
     * voer DELETE-query uit
     */
    public function delete()
    {

        return $this->executed_statement($this->deleteQuery())->rowCount();
    }

    /**
     * getter voor het PDO-statement-object
     */
    private function executed_statement($query)
    {
        $statement = Database::getInstance()->pdo->prepare($query);

        foreach ($this->binds as $bind)
        {
            $statement->bindValue($bind['placeholder'], $bind['value'], $bind['type']);
        }

        $statement->execute();

        return $statement;
    }

    /**
     * getter voor de SQL van een SELECT-query
     */
    private function selectQuery()
    {
        return 'SELECT * FROM ' . $this->class::TABLE_NAME . ' ' . $this->where;
    }

    /**
     * getter voor de SQL van een DELETE-query
     */
    private function deleteQuery()
    {
        return 'DELETE FROM ' . $this->class::TABLE_NAME . ' ' . $this->where;
    }

    public function insert($values)
    {
        $placeholders = [];

        foreach($values as $field => $value)
        {
            $placeholders[] = $this->bind($field, $value);
        }
        $fields = array_keys($values);
        $statement = $this->executed_statement($this->insertQuery($fields, $placeholders));

        return Database::getInstance()->pdo->lastInsertId();
    }

    private function insertQuery($fields, $placeholders)
    {
        var_dump($fields);
        var_dump($placeholders);

        return 'INSERT INTO ' . $this->class::TABLE_NAME . '(' . implode(',',$fields) . ') VALUES(' . implode(',', $placeholders) . ')';
    }

}
