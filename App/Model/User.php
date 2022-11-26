<?php

namespace App\Model;

use App\Database\Model;

class User extends Model {

    protected string $table = 'users';

    protected array $fillable = [
        'city_id',
        'name',
        'email',
        'password',
        'age',
        'sex',
        'telephone'
    ];
    
}