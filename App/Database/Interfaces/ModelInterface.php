<?php

namespace App\Database\Interfaces;

interface ModelInterface {
    public function get(array $columns = ['*']);
}