<?php

$router->post('/user/create', 'UserController@createUser');

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', 'AuthController@login');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('/list', 'UserController@listUsers');
    $router->get('/list/{id}', 'UserController@listOneUser');

    $router->patch('/partial-update/{id}', 'UserController@updateUserNameAndEmail');

    $router->delete('/delete/{id}', 'UserController@deleteUser');
});

$router->group(['prefix' => 'todo', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/list', 'TodoController@listTodo');
    $router->get('/list/{id}', 'TodoController@listOneTodo');
    $router->get('/list/user/{id}', 'TodoController@listTodoUser');

    $router->post('/create', 'TodoController@createTodo');

    $router->put('/update/{id}', 'TodoController@updateTodo');

    $router->delete('/delete/{id}', 'TodoController@deleteTodo');
});
