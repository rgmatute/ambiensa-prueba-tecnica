<?php

    $router->group(['prefix' => 'api/v1'], function () use ($router) {
        $router->post('/account/authenticate', 'AccountController@login');
    });
