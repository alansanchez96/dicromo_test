<?php

namespace Src\Modules\Auth\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Src\Modules\Auth\Application\Commands\UpdateUserCommand;
use Src\Modules\Auth\Application\Queries\UserInformationQuery;
use Src\Modules\Auth\Infrastructure\Requests\InformationUpdateRequest;

class InformationUpdate extends LaravelController
{
    public function __construct(private readonly UserInformationQuery $query, private readonly UpdateUserCommand $command) { parent::__construct(); }

    public function __invoke(InformationUpdateRequest $rq): JsonResponse
    {
        try {
            $statusUser = $this->query->execute();

            if (is_int($statusUser))
                return $this->response->httpStatus($statusUser);

            $statusUser = $this->command->updateUser($statusUser, $rq);

            if ($statusUser instanceof AuthDB)
                return response()->json([
                    'data' => $statusUser
                ], 200);
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}
