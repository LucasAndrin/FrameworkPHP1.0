<?php

namespace App\Database;

require_once 'vendor/autoload.php';

use App\Database\{
    PdoConnection, 
    QueryBuilder
};
use App\Database\Interfaces\ModelInterface;
use InvalidArgumentException;

class Model implements ModelInterface {

    protected string $primaryKey = 'id';

    protected string $table;

    protected array $fillable;

    protected QueryBuilder $queryBuilder;

    protected PdoConnection $pdoConnection;

    public function __construct(){
        $this->queryBuilder = new QueryBuilder($this->table);
        $this->pdoConnection = new PdoConnection;
    }

    public function get(array $columns = ['*']): array
    {
        $this->queryBuilder->select($columns);

        $this->pdoConnection->prepare($this->queryBuilder->getQuery());

        $this->bindAll();
        
        $this->pdoConnection->execute();

        $this->queryBuilder->resetQueryBuilder();

        return $this->pdoConnection->fetchAll();
    }

    public function update(array $fields)
    {
        if (count(array_diff($this->fillable, $fields))) {
            throw new InvalidArgumentException("Invalid fields to update! Check fillable attribute on your model");
        }

        $this->queryBuilder->update($fields);

        $this->pdoConnection->prepare($this->queryBuilder->getQuery());

        $this->bindAll();
        
        $this->pdoConnection->execute();

        $this->queryBuilder->resetQueryBuilder();
    }

    public function find(string|int $key): object
    {
        $this->where($this->primaryKey, '=', $key);

        return $this;
    }

    public function where($column, $operator, $value): object
    {
        $this->queryBuilder->where($column, $operator, $value);

        return $this;
    }

    private function bindAll()
    {
        $this->pdoConnection->bindValues($this->queryBuilder->getWhereParams());
    }

}