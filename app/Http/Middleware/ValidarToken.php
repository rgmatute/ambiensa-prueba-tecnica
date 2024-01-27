<?php
namespace App\Http\Middleware;
use App\AuthToken\JWToken;
use Closure;

class ValidarToken{
    public function handle($request, Closure $next){
        $obj_JWToken = new JWToken;
        $response = [];
        $token = $request->header('Authorization');
        if (!$token) {
            $response = [
                "message" => 'No se encuentra autenticado.'
            ];
        } else {
            $datos = $obj_JWToken->validarToken($token);
            if ($datos['valido']){
                return $next($request);
                #->header('Token',$datos['nuevoToken']);
            } else {
                $response = [
                    "message" => 'Su sesion ha caducado.'
                ];
            }
        }
        return response()->json($response, 401);
    }
}
?>
