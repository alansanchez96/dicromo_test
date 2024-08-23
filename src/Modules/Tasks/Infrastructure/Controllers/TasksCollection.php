<?php

namespace Src\Modules\Tasks\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Tasks\Application\Queries\GetTasksQuery;
use Src\Modules\Tasks\Infrastructure\Resources\TaskResource;

class TasksCollection extends LaravelController
{
    public function __construct(private readonly GetTasksQuery $q) { parent::__construct(); }

    public function __invoke(Request $rq)
    {
        try {
            $statusTasks = $this->q->getTasksCollection($rq);

            if ($statusTasks === 500) return $this->response->httpStatus($statusTasks);

            if ($statusTasks instanceof Collection)
                return $this->response->success_get(TaskResource::collection($statusTasks));

        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}