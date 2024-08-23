<?php

namespace Src\Modules\Tasks\Infrastructure\Controllers;

use Src\Modules\Tasks\Infrastructure\Database\Task;
use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Tasks\Infrastructure\Requests\TaskRequest;
use Src\Modules\Tasks\Application\Command\TaskCreateCommand;
use Src\Modules\Tasks\Infrastructure\Resources\TaskResource;

class TaskCreate extends LaravelController
{
    public function __construct(private readonly TaskCreateCommand $cmd) { parent::__construct(); }

    public function __invoke(TaskRequest $rq)
    {
        try {
            $statusTask = $this->cmd->createTask($rq);

            if ($statusTask === 500 || $statusTask === 422) return $this->response->httpStatus($statusTask);

            if ($statusTask instanceof Task)
                return $this->response->success_write('registrado', new TaskResource($statusTask));
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}