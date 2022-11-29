<?php

require 'vendor/autoload.php';

use App\Model\User;

$user = new User;

echo '<pre>';

var_dump($user->get());

var_dump($user->find(1)->get());

var_dump($user->where('name', '=', 'Jéssica')->get());

var_dump($user->find(2)->update(['name' => 'João', 'sex' => 1]));

var_dump($user->insert([
    'name' => 'Sabrina',
    'sex' => 1,
    'city_id' => 1,
    'email' => 'sabrina@gmai.com',
    'password' => 'teste',
    'age' => 20,
    'telephone' => 12312321
]));

var_dump($user->where('name', '=', 'Sabrina')->delete());