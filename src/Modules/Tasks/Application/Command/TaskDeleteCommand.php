<?php

namespace Src\Modules\Tasks\Application\Command;

use Src\Common\UseCases;
use Illuminate\Http\Request;
use Src\Common\Interfaces\Laravel\EloquentModel;
use Src\Modules\Tasks\Infrastructure\Database\Task;
use Src\Modules\Tasks\Domain\Contracts\ITaskRepository;
use Src\Modules\Tasks\Domain\Domain\Entities\TaskEntity;

class TaskDeleteCommand extends UseCases
{
    public function __construct(private readonly ITaskRepository $repository)
    {
        parent::__construct();
    }

    public function deleteTask(Task $task)
    {
        return $this->repository->delete($task);
    }

    public function getEntity(Request $rq, EloquentModel $model = null)
    {
        $entity = new TaskEntity;

        if (isset($rq->id))
            $entity->setId($rq->id);
        
        return $entity->toArray();
    }
}