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

    /**
     * Get especific columns from table
     * 
     * @param array $columns
     * @return array result of fetch all
     */
    public function get(array $columns = ['*']): array
    {
        $this->queryBuilder->select($columns);

        $this->pdoConnection->prepare($this->queryBuilder->getQuery());

        $this->bindAll();
        
        $this->pdoConnection->execute();

        $this->queryBuilder->resetQueryBuilder();

        return $this->pdoConnection->fetchAll();
    }

    /**
     * Insert insert in queryBuilder and execute sql query
     * 
     * @param array $fields
     * @return int number of rows inserted
     */
    public function insert(array $fields): int
    {
        foreach ($fields as $field => $value) {
            if (!in_array($field, $this->fillable)) {
                throw new InvalidArgumentException("'$field' doesn't appear in fillable attribute in your model");
            }
        }

        $this->queryBuilder->insert($fields);

        $this->pdoConnection->prepare($this->queryBuilder->getQuery());

        $this->bindAll();

        $this->queryBuilder->resetQueryBuilder();

        return $this->pdoConnection->execute();
    }

    /**
     * Insert update in queryBuilder and execute sql query
     * 
     * @param array $fields
     * @return int number of rows affected
     */
    public function update(array $fields): int
    {
        foreach ($fields as $field => $value) {
            if (!in_array($field, $this->fillable)) {
                throw new InvalidArgumentException("'$field' doesn't appear in fillable attribute in your model");
            }
        }

        $this->queryBuilder->update($fields);

        $this->pdoConnection->prepare($this->queryBuilder->getQuery());

        $this->bindAll();

        $this->queryBuilder->resetQueryBuilder();

        return $this->pdoConnection->execute();
    }

    /**
     * Builder where query using query builder especial for primaryKey
     * 
     * @param string|int $key
     * @return object $this
     */
    public function find(string|int $key): object
    {
        $this->where($this->primaryKey, '=', $key);

        return $this;
    }

    /**
     * Build where query using query builder
     * 
     * @param string $column - table column
     * @param string $operator - logic operator
     * @param mixed $value - column value
     * @return object $this - model
     */
    public function where(string $column, string $operator, mixed $value): object
    {
        $this->queryBuilder->where($column, $operator, $value);

        return $this;
    }

    /**
     * Bind all values used in querybuilder
     */
    private function bindAll(): void
    {
        $this->pdoConnection->bindValues(
            $this->queryBuilder->getWhereParams(),
            $this->queryBuilder->getInsertParams(),
            $this->queryBuilder->getUpdateParams()
        );
    }

}