<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
        $response = $next($request);
        //$response->header('Access-Control-Allow-Origin','192.168.0.7');

        $response->header('Access-Control-Allow-Origin', '*');
        $response->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
        /*$response->header('Access-Control-Allow-Method', '*');
        $response->header('Access-Control-Allow-Headers', '*');
        $response->header("Access-Control-Allow-Credentials", false);
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');*/

        /*return $next($request)
          ->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
          ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type,X-Token-Auth, Authorization');*/

        return $response;
    }
}

