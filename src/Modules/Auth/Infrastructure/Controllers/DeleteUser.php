<?php

namespace Src\Modules\Auth\Infrastructure\Controllers;

use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Src\Modules\Auth\Application\Commands\DeleteUserCommand;
use Src\Modules\Auth\Application\Queries\UserInformationQuery;

class DeleteUser extends LaravelController
{
    public function __construct(private readonly UserInformationQuery $query, private readonly DeleteUserCommand $command) { parent::__construct(); }

    public function __invoke()
    {
        try {
            $statusUser = $this->query->execute();

            if (is_int($statusUser))
                return $this->response->httpStatus($statusUser);

            $statusUser = $this->command->deleteUser($statusUser);

            if ($statusUser === 422)
                return response()->json([
                    'message' => 'No se ha podido eliminar'
                ], 200);

            if ($statusUser === 200)
                return response()->json([
                    'message' => 'Usuario y session eliminados'
                ], 200);
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}