<?php

namespace App\Http\Controllers;

use App\Http\Respuesta\Utils;
use App\Service\AccountService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\AuthToken\JWToken;

class AccountController extends Controller
{
    use Utils;

    private $accountService;

    public function __construct(){
        $this->accountService = new AccountService();
    }

    public function login(Request $request)
    {
        $request = json_decode($request->getContent(), true);

        $bearerToken = $this->accountService->login($request);

        return $this->successLogin($bearerToken);

    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->header('Authorization');

        $this->accountService->destruirToken($token);

        return $this->successOnlyMessage();
    }

    public function logout_(Request $request): JsonResponse
    {
        try {
            $jwt = new JWToken();
            $token = $request->header('Authorization');

            $jwt->destruirToken($token, null, 0);

            //$this->notificarEvent($this->user_id, 'Ha cerrado sesion');
            return response()->json(['message' => "Sesión cerrada exitósamente"]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        return response()->json(null);
    }
}
