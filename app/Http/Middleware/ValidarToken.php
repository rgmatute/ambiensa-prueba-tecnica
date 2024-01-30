<?php
namespace App\Http\Middleware;
use App\AuthToken\JWToken;
use App\Exceptions\GenericException;
use Closure;

class ValidarToken {
    /**
     * @throws GenericException
     */
    public function handle($request, Closure $next){
        $obj_JWToken = new JWToken;
        $response = [];
        $token = $request->header('Authorization');
        if (!isset($token)) {
            throw new GenericException("No se encuentra autenticado!", 401);
            // dd($obj_JWToken, $token);
        } else {
            // $datos = $obj_JWToken->validarToken($token);
            if($obj_JWToken->isValid($token)){
                return $next($request);
            }else{
                throw new GenericException("La sesion ha caducado!", 401);
            }
            // dd($obj_JWToken, $token, $datos);
        }
    }
}
?>
