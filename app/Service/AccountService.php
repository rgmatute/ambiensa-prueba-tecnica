<?php

namespace App\Service;

use App\AuthToken\JWToken;
use App\Exceptions\GenericException;
use App\Http\Respuesta\Utils;
use App\Repository\ClientsRepository;

class AccountService
{

    use Utils;
    private $clientsRepository;

    public function __construct(){
        $this->clientsRepository = new ClientsRepository();
    }

    /**
     * @throws GenericException
     */
    public function login($credentials) {

        $email = $credentials['email'];
        $password = $credentials['password'];

        if(!isset($email)){
            throw new GenericException('email es requerido!', 400);
        }

        if(!isset($password)){
            throw new GenericException('password es requerido!', 400);
        }

        $client = $this->clientsRepository->findByEmail($credentials['email']);

        if(!$this->verifyPassword($password, $client['password'])){
            throw new GenericException('Credenciales incorrectas!', 400);
        }

        $jwt     = new JWToken();
        return $jwt->generarToken($client['email'], 1);
    }

    /**
     * @throws GenericException
     */
    public function destruirToken($token) {

        if(!isset($token)){
            throw new GenericException('Necesita adjuntar el token en la cabecera de la consulta!', 400);
        }

        $jwt = new JWToken();

         // return ($jwt->validarToken($token));
        if(!$jwt->isValid($token)){
            throw new GenericException("El token no es valido - !");
        }

        $jwt->destruirToken($token, null, 0);
    }

}
