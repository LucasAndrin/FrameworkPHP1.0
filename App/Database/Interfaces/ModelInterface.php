<?php

namespace App\Database\Interfaces;

require_once 'vendor/autoload.php';

interface ModelInterface {

    /**
     * Get especific columns from table
     * 
     * @param array $columns
     * @return array result of fetch all
     */
    public function get(array $columns = ['*']): array;

    /**
     * Builder where query using query builder especial for primaryKey
     * 
     * @param string|int $key
     * @return object $this
     */
    public function find(string|int $key): object;

    /**
     * Build where query using query builder
     * 
     * @param string $column - table column
     * @param string $operator - logic operator
     * @param mixed $value - column value
     * @return object $this - model
     */
    public function where(string $column, string $operator, mixed $value): object;

    /**
     * Build join query usign query builder
     * 
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @return object $this
     */
    public function join(string $table, string $firstColumn, string $secondColumn): object;

    /**
     * Insert insert in queryBuilder and execute sql query
     * 
     * @param array $fields
     * @return int number of rows inserted
     */
    public function insert(array $fields): int;

    /**
     * Insert update in queryBuilder and execute sql query
     * 
     * @param array $fields
     * @return int number of rows affected
     */
    public function update(array $fields): int;

    /**
     * 
     */
    public function delete(): int;

}