<?php

namespace App\Database;

require_once 'vendor/autoload.php';

class Where {

    private string $column;

    private string $operator;

    private $value;

    function __construct($column, $operator = '=', $value)
    {
        $arguments = func_get_args();
        $numberOfArguments = count($arguments);

        if ($numberOfArguments === 3) {
            call_user_func_array([$this, 'construct'], $arguments);
        } else if ($numberOfArguments === 2) {
            call_user_func_array([$this, 'constructWithDefaultOperator'], $arguments);
        }
    }

    private function constructWithDefaultOperator($column, $value)
    {
        $this->setColumn($column);
        $this->setOperator('=');
        $this->setValue($value);
    }

    private function construct($column, $operator, $value)
    {
        $this->setColumn($column);
        $this->setOperator($operator);
        $this->setValue($value);
    }

    /**
     * Getters and Setters
     */
    public function setColumn(string $column): void
    {
        $this->column = $column;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function setOperator(string $operator): void
    {
        $this->operator = $operator;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

}