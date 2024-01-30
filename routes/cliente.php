<?php
    $router->group(['prefix' => 'api/v1'], function () use ($router) {
        $router->group(['middleware' => 'auth'], function() use ($router) {
            $router->get('/clients', 'ClientsController@index');
            $router->get('/clients/{id}', 'ClientsController@show');
            $router->put('/clients/{id}', 'ClientsController@update');
            $router->delete('/clients/{id}', 'ClientsController@delete');
            $router->get('/client/search', 'ClientsController@search');
        });

        // Queda fuera del middleware por que se utilizara para registro de usuario
        $router->post('/clients', 'ClientsController@store');
    });
