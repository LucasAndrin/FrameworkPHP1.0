<?php

require 'vendor/autoload.php';

use App\Model\User;

$user = new User;

echo '<pre>';

// print_r($user->get());

// print_r($user->find(1)->get());

// print_r($user->where('name', '=', 'Jéssica')->get());

// print_r($user->find(2)->update(['name' => 'João', 'sex' => 1]));

print_r($user->insert([
    'name' => 'Sabrina',
    'sex' => 1,
    'city_id' => 1,
    'email' => 'sabrina@gmai.com',
    'password' => 'teste',
    'age' => 20,
    'telephone' => 12312321
]));
