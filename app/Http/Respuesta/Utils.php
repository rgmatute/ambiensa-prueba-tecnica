<?php

namespace App\Http\Respuesta;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait Utils
{
    // Método para formatear una respuesta exitosa
    public function successResponse($data, $statusCode = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Transacción realizada correctamente!'
        ], $statusCode);
    }

    public function successOnlyMessage($statusCode = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Transacción realizada correctamente!'
        ], $statusCode);
    }

    // Método para formatear una respuesta de error
    public function errorResponse($message, $statusCode) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? 'aaaaaaaaa'
        ], $statusCode);
    }

    public function password($value) {
        return password_hash($value, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function verifyPassword($password, $password_hash) {
        return password_verify($password, $password_hash);
    }

    public function successLogin($bearerToken, $statusCode = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'id_token' => $bearerToken
        ], $statusCode);
    }
}
