<?php

namespace Src\Modules\Auth\Infrastructure\Controllers;

use Illuminate\Support\Facades\DB;
use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Auth\Application\Queries\LoginQuery;
use Src\Modules\Auth\Infrastructure\Requests\RegisterRequest;
use Src\Modules\Auth\Application\Commands\RegisterUserCommand;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;

class Register extends LaravelController
{
    public function __construct(private readonly RegisterUserCommand $command, private readonly LoginQuery $query)
    {
        parent::__construct();
    }

    public function __invoke(RegisterRequest $request)
    {
        try {
            $userRegister = $this->command->registerAUser($request);

            if (!$userRegister) return response()->json(['message' => 'Ocurrio un error al registrar', 'status' => $userRegister]);

            if ($userRegister instanceof AuthDB) {
                $status = $this->query->login($request);
    
                if (!$status) return response()->json(['message' => 'Usuario/Contraseña incorrectos', 'status' => $status]);
            }

            return response()->json($status, 200);
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}
