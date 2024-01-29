<?php
    $router->group(['prefix' => 'api/v1'], function () use ($router) {
        //$router->group(['namespace' => 'Account'], function () use ($router) {
        // $router->post('/accounts', 'AccountController@register');
        // $router->post('/accounts/auth', 'AccountController@login');
        $router->get('/clients', 'ClientsController@index');
        $router->get('/clients/{id}', 'ClientsController@show');
        $router->post('/clients', 'ClientsController@store');
        // $router->post('/accounts/resend-code', 'AccountController@resendCode');

        // $router->post('/accounts/recovery-password', 'AccountController@recoveryPassword');

        /*
        $router->group(['middleware' => 'auth'], function() use ($router) {
            # ACTUALIZAR CONTRASEÑA
            $router->post('/accounts/update-password', 'AccountController@passwordUpdate');

            $router->post('/accounts/inactivar/{id}', 'AccountController@inactivar');
        });
        */
        //});
    });
