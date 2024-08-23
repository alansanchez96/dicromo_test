<?php

namespace Src\Modules\Auth\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Auth\Application\Queries\LoginQuery;
use Src\Modules\Auth\Infrastructure\Requests\LoginRequest;

class Authentication extends LaravelController
{
    public function __construct(private readonly LoginQuery $query)
    {
        parent::__construct();
    }

    public function __invoke(LoginRequest $request)
    {
        try {
            $status = $this->query->login($request);
            // dd($status);
            if (!$status) return response()->json(['message' => 'Usuario/Contraseña incorrectos', 'status' => $status]);

            return response()->json($status, 200);
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}
