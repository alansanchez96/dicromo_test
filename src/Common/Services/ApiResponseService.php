<?php

namespace Src\Common\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseService
{
    public function success_get(mixed $value = null): JsonResponse
    {
        $data = [
            'message' => "Se ha obtenido correctamente.",
            ($value === null) ?: 'data' => $value,
        ];

        return response()
            ->json(array_filter($data), Response::HTTP_OK);
    }

    public function success_write(string $action, mixed $value = null): JsonResponse
    {
        $data = [
            'message' => "Se ha {$action} correctamente.",
            ($value === null) ?: 'data' => $value,
        ];

        return response()
            ->json(array_filter($data), Response::HTTP_CREATED);
    }

    public function failure(\Exception $e): JsonResponse
    {
        Log::debug('LogsException', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'code' => $e->getCode(),
            'exception' => $e
        ]);

        return response()
            ->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'e' => $e
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function httpStatus($status)
    {
        if ($status === 422)
            return response()->json([
                'message' => 'No identificado'
            ], $status);
    }
}
