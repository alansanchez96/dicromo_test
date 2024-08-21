<?php

namespace Src\Modules\Auth\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Auth\Application\Queries\LogoutQuery;

class Logout extends LaravelController
{
    public function __construct(private readonly LogoutQuery $logout) {}

    public function __invoke(): JsonResponse
    {
        try {
            $status = $this->logout->execute();

            $message = $status === 422 ? 'No identificado' : 'Sesión cerrada';

            return response()->json([
                'message' => $message
            ], 200);
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}
