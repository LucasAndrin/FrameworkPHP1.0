<?php

require 'vendor/autoload.php';

use App\Model\User;

$user = new User;

echo '<pre>';

// print_r($user->get());

// print_r($user->find(1)->get());

// print_r($user->where('name', '=', 'Jéssica')->get());

print_r($user->find(2)->update(['name' => 'João', 'sex' => 1]));
