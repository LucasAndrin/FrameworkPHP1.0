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

    protected array $updateParams = [];

    protected array $insertParams = [];

    protected string $where = 'WHERE';

    protected string $and = 'AND';

    protected string $select = 'SELECT';

    protected string $insert = 'INSERT INTO';

    protected string $delete = 'DELETE FROM';

    protected string $update = 'UPDATE';

    protected string $values = 'VALUES';

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

    public function getInsertParams()
    {
        return $this->insertParams;
    }

    public function getUpdateParams()
    {
        return $this->updateParams;
    }

    private function addWhereParams($column, $value)
    {
        $this->whereParams[$column] = $value;
    }

    private function addUpdateParams(array $updateParams)
    {
        $this->updateParams = $updateParams;
    }

    private function addInsertParams(array $insertParams)
    {
        $this->insertParams = $insertParams;
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

        $this->updateParams = [];

        $this->insertParams = [];
    }

    /**
     * Executive Methods
     */
    public function select(array $columns) 
    {
        $columns = implode(",", $columns);

        $this->prependQuery("$this->select $columns FROM {$this->getTable()}");
    }

    public function insert(array $fields)
    {
        $this->addInsertParams($fields);

        $fieldsToBind = array_keys($fields);

        $columns = implode(",", $fieldsToBind);

        $values = ':'.implode(",:", $fieldsToBind);

        $this->prependQuery("$this->insert $this->table($columns) $this->values($values)");
    }

    public function update(array $fields)
    {
        $this->addUpdateParams($fields);

        $fieldsToBind = array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($fields));

        $fieldsToBind = implode(",", $fieldsToBind);

        $this->prependQuery("$this->update $this->table SET $fieldsToBind");
    }

    public function delete()
    {
        $this->prependQuery("$this->delete $this->table");
    }

    public function where($column, $operator, $value)
    {
        $this->appendQuery((count($this->getWhereParams()) ? $this->and : $this->where).' '.$column.' '.$operator.' :'.$column);
        
        $this->addWhereParams($column, $value);
    }

}