<?php

namespace App\Database;

require_once 'vendor/autoload.php';

class QueryBuilder {

    private string $query = '';

    private string $table;

    private string $action;

    private array $get = [];

    private array $where = [];

    private array $join = [];

    protected array $logicOperators = [
        '=', '<>', '>', '>=', '<', '<=' 
    ];

    protected string $select = 'SELECT';

    protected string $insert = 'INSERT INTO';

    protected string $delete = 'DELETE';

    protected string $update = 'UPDATE';

    function __construct($table)
    {
        $this->setTable($table);
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getQuery()
    {
        return $this->query;
    }

    private function setQuery(string $query)
    {
        $this->query = $query;
    }

    private function appendQuery(string $query)
    {
        $this->setQuery($this->getQuery().$query);
    }

    private function prependQuery(string $query)
    {
        $this->setQuery($query.$this->getQuery());
    }

    /**
     * MMÉTODOS CONSTRUTORES
     */
    public function get(array $requiredColumns) 
    {
        $query = $this->select.' ';
        $lastColumnKey = count($requiredColumns) - 1;

        foreach ($requiredColumns as $key => $column) {
            $query .= $column;
            if ($lastColumnKey != $key) {
                $query .= ', ';
            }
        }

        $this->prependQuery($query);
    }

}