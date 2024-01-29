<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use App\AuthToken\JWToken;
use App\Services\AccountService;

class AccountController extends Controller
{
    private $accountService;

    public function __construct(){
        $this->accountService = new AccountService();
    }

    /**
     * @throws Exception
     */
    public function register(Request  $request): JsonResponse
    {
        $request = json_decode($request->getContent(), true);

        try {

            //$this->accountService = new AccountService();

            $message = $this->accountService->register($request);

            return response()->json(['message' => $message], 201);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request): JsonResponse
    {

        $request = json_decode($request->getContent(), true);

        try {

            //$this->accountService = new AccountService();

            $user = $this->accountService->login($request['username'], $request['password']);

            $currentRole = json_decode($user->authorities)[0]->id;

            $jwt     = new JWToken();

            $token = $jwt->generarToken($user->login, $currentRole);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request): JsonResponse
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

    /**
     *
     */
    public function activated(Request $request): JsonResponse
    {
        try {

            $request = json_decode($request->getContent(), true);

            $message = $this->accountService->activated($request);

            return response()->json(['message' => $message]);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        return response()->json(null);
    }

    /**
     *
     */
    public function inactivar($id): JsonResponse
    {
        try {

            $message = $this->accountService->inactivar($id);
            return response()->json(['message' => $message]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        return response()->json(null);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resendCode(Request $request): JsonResponse
    {
        try {
            $request = json_decode($request->getContent(), true);
            $message = $this->accountService->resendCode($request);
            return response()->json(['message' => $message]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() === 0 ? 500 : $e->getCode());
        }
    }

    /**
     * @param Request $request
     */
    public function recoveryPassword(Request $request){
        try {
            $request = json_decode($request->getContent(), true);
            $message = $this->accountService->recoveryPassword($request);
            return response()->json(['message' => $message]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() === 0 ? 500 : $e->getCode());
        }
    }
}
