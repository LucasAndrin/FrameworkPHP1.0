<?php

namespace App\Database\Interfaces;

require_once 'vendor/autoload.php';

interface ModelInterface {
    public function get(array $columns = ['*']);
}