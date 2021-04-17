<?php

use App\Models\User;
use App\Models\Todo;


$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('/list', 'UserController@listUsers');
    $router->get('/list/{id}', 'UserController@listOneUser');

    $router->post('/create', 'UserController@createUser');

    $router->patch('/partial-update/{id}', 'UserController@updateUserNameAndEmail');

    $router->delete('/delete/{id}', 'UserController@deleteUser');
});

$router->group(['prefix' => 'todo'], function() use ($router) {
    $router->get('/list', 'TodoController@listTodo');
});
