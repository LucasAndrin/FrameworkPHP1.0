<?php

namespace App\Database\Interfaces;

require_once 'vendor/autoload.php';

interface ModelInterface {

    public function get(array $columns = ['*']): array;

    public function find(string|int $key): object;

    public function where($column, $operator, $value): object;

}