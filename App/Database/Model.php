<?php

namespace App\Database;

require_once 'vendor/autoload.php';

use App\Database\{
    PdoConnection,
    QueryBuilder
};
use App\Database\Interfaces\ModelInterface;
use InvalidArgumentException;

class Model implements ModelInterface
{

    protected string $primaryKey = 'id';

    protected string $table;

    protected array $fillable;

    protected QueryBuilder $queryBuilder;

    protected PdoConnection $pdoConnection;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder($this->table);
        $this->pdoConnection = new PdoConnection;
    }

    public function get(array $columns = ['*']): array
    {
        $this->queryBuilder->select($columns);

        $this->pdoConnection->prepare($this->queryBuilder->getQuery());

        $this->prepare();

        $this->pdoConnection->execute();

        return $this->pdoConnection->fetchAll();
    }

    public function find(string|int $key): object
    {
        $this->where($this->primaryKey, '=', $key);

        return $this;
    }

    public function where(string $column, string $operator, mixed $value): object
    {
        $this->queryBuilder->where($column, $operator, $value);

        return $this;
    }

    public function join(string $table, string $firstColumn, string $secondColumn): object
    {
        $this->queryBuilder->join($table, $firstColumn, $secondColumn);

        return $this;
    }

    public function insert(array $fields): int
    {
        foreach ($fields as $field => $value) {
            if (!in_array($field, $this->fillable)) {
                throw new InvalidArgumentException("'$field' doesn't appear in fillable attribute in your model");
            }
        }

        $this->queryBuilder->insert($fields);

        $this->prepare();

        return $this->pdoConnection->execute();
    }

    public function update(array $fields): int
    {
        foreach (array_keys($fields) as $key) {
            if (!in_array($key, $this->fillable)) {
                throw new InvalidArgumentException("'$key' doesn't appear in fillable attribute in your model");
            }
        }

        $this->queryBuilder->update($fields);

        $this->prepare();

        return $this->pdoConnection->execute();
    }

    public function delete(): int
    {
        $this->queryBuilder->delete();

        $this->prepare();

        return $this->pdoConnection->execute();
    }

    private function prepare()
    {
        $this->pdoConnection->prepare($this->queryBuilder->getQuery());

        $this->pdoConnection->bindValues(
            $this->queryBuilder->getWhereParams(),
            $this->queryBuilder->getInsertParams(),
            $this->queryBuilder->getUpdateParams()
        );

        $this->queryBuilder->resetQueryBuilder();
    }
}
