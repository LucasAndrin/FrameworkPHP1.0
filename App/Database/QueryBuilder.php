<?php

namespace App\Database;

require_once 'vendor/autoload.php';

class QueryBuilder {

    private string $query = '';

    private string $table;

    protected array $logicOperators = [
        '=', '<>', '>', '>=', '<', '<=' 
    ];

    protected array $whereParams = [];

    protected string $where = 'WHERE';

    protected string $and = 'AND';

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

    public function getWhereParams()
    {
        return $this->whereParams;
    }

    private function addWhereParams($column, $value)
    {
        $this->whereParams[$column] = $value;
    }

    private function appendQuery(string $query)
    {
        $this->setQuery($this->getQuery().' '.$query);
    }

    private function prependQuery(string $query)
    {
        $this->setQuery($query.' '.$this->getQuery());
    }

    public function resetQueryBuilder()
    {
        $this->query = '';

        $this->whereParams = [];
    }

    /**
     * MÉTODOS CONSTRUTORES
     */
    public function select(array $requiredColumns) 
    {
        $query = $this->select.' ';
        $lastColumnKey = count($requiredColumns) - 1;

        foreach ($requiredColumns as $key => $column) {
            $query .= $column;
            if ($lastColumnKey != $key) {
                $query .= ',';
            }
        }

        $query .= " FROM {$this->getTable()}";

        $this->prependQuery($query);
    }

    public function update(array $fields)
    {
        $query = "{$this->update} $this->table SET ";

        $lastColumnKey = array_key_last($fields);

        foreach ($fields as $field => $value) {

            $query .= "$field = ";

            if (is_string($value)) {
                $query .= "'$value'";
            } else {
                $query .= "$value";
            }

            if ($lastColumnKey != $field) {
                $query .= ',';
            }
        }

        $this->prependQuery($query);
    }

    public function where($column, $operator, $value)
    {
        $this->appendQuery((count($this->getWhereParams()) ? $this->and : $this->where).' '.$column.' '.$operator.' :'.$column);
        
        $this->addWhereParams($column, $value);
    }

}