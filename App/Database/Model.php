<?php

namespace App\Database;

use App\Database\{
    PdoConnection, 
    QueryBuilder
};
use App\Database\Interfaces\ModelInterface;

class Model implements ModelInterface {

    protected string $primaryKey = 'id';

    protected string $table;

    protected array $fillable;

    public function get(array $columns = ['*']) {
        $queryBuilder = new QueryBuilder($this->table);
        $pdoConnection = new PdoConnection;
        
        $queryBuilder->get($columns);

        $pdoConnection->prepare($queryBuilder->getQuery());
        
        $pdoConnection->execute();

        return $pdoConnection->fetchAll();
    }
    
}