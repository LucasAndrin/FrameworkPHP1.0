<?php

require 'vendor/autoload.php';

use App\Model\User;

$user = new User;

echo '<pre>';

print_r($user->get(['name']));