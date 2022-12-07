<?php

require_once 'vendor/autoload.php';

use App\Http\{
    Router,
    Request
};
use App\Model\User;
use App\Http\Controllers\UserController;

$router = new Router(new Request);

$user = new User;

$router->get('/', [UserController::class, "helloWorld"]);

$router->get('/profile', function($request) use($user) {
    var_dump($user->get());
});

$router->post('/get-body', function($request) {
    return json_encode($request->getBody());
});