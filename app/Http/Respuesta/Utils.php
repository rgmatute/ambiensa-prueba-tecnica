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
            'message' => 'Transacción realizada correctamnente!'
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
}
