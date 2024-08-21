<?php

namespace Src\Modules\Auth\Infrastructure\Controllers;

use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Src\Modules\Auth\Application\Queries\UserInformationQuery;

class Information extends LaravelController
{
    public function __construct(private readonly UserInformationQuery $query) { parent::__construct(); }

    public function __invoke()
    {
        try {
            $statusUser = $this->query->execute();

            if (is_int($statusUser))
                return $this->response->httpStatus($statusUser);

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
