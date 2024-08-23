<?php

namespace Src\Modules\Tasks\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\Modules\Tasks\Infrastructure\Database\Task;
use Src\Common\Interfaces\Laravel\LaravelController;
use Src\Modules\Tasks\Application\Queries\GetTasksQuery;
use Src\Modules\Tasks\Application\Command\TaskDeleteCommand;

class TaskDelete extends LaravelController
{
    public function __construct(private readonly GetTasksQuery $q, private readonly TaskDeleteCommand $cmd) { parent::__construct(); }

    public function __invoke(Request $rq, $id)
    {
        try {
            $task = $this->q->getTask($rq);

            if ($task === 500 || $task === 422) return $this->response->httpStatus($task);

            if ($task instanceof Task)
                $task = $this->cmd->deleteTask($task);

                return $this->response->success_write('eliminado');
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return $this->response->failure($e);
        }
    }
}