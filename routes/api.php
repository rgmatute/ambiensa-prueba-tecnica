<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/../routes/cliente.php';
require __DIR__ . '/../routes/mock.php';
require __DIR__.'/../routes/webhook.php';

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//Fix to Method OPTIONS
$router->options('/{any:.*}', function () {
    return response(['status' => 'success'])
        ->header('Access-Control-Allow-Methods','OPTIONS, GET, POST, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Authorization, Content-Type, Origin');
});

$router->get('/', function () use ($router) {
    // return $router->app->version();
    return response()->json([
        'success' => true,
        'framework' => $router->app->version()
    ]);
});

// $router->group(['middleware' => 'auth'], function() use ($router){
    $router->get('key', function(){
        return response()->json([
            'success' => false,
            'key' => Str::random(32)
        ]);
    });
//});


$router->get('hash/{value}', function($value){
    $valueHash = password_hash($value, PASSWORD_BCRYPT, ['cost' => 10]);
    $info = password_get_info( $valueHash );
    $verify = password_verify($value, $valueHash);

    /*
    $valueHash  = Hash::make( $value );
    $info       = Hash::info( $valueHash );
    $verify     = Hash::check( $value, $valueHash );
    */

    return response()->json([
        'success'     => true,
        'data' => [
            'value'     => $value,
            'valueHash' => $valueHash,
            'infoHash'  => $info,
            'verifyHash'=> $verify
        ]
    ]);
});

