<?php

namespace Src\Modules\Tasks\Application\Command;

use Src\Common\UseCases;
use Illuminate\Http\Request;
use Src\Common\Interfaces\Laravel\EloquentModel;
use Src\Modules\Tasks\Infrastructure\Database\Task;
use Src\Modules\Tasks\Domain\Contracts\ITaskRepository;
use Src\Modules\Tasks\Domain\Domain\Entities\TaskEntity;

class TaskUpdateCommand extends UseCases
{
    public function __construct(private readonly ITaskRepository $repository)
    {
        parent::__construct();
    }

    public function taskUpdate(Task $task, $rq)
    {
        $entity = $this->getEntity($rq, $task);

        return $this->repository->update($task, $entity);
    }

    public function getEntity(Request $rq, EloquentModel $model = null)
    {
        $entity = new TaskEntity;

        $entity->setUserId($rq->user_id ?? auth()->userOrFail()->id);

        isset($rq->status) ? $entity->setStatus($rq->status) : $entity->setName($model->status);

        isset($rq->name) ? $entity->setName($rq->name) : $entity->setName($model->name);

        isset($rq->description) ? $entity->setDescription($rq->description) : $entity->setName($model->description);

        return $entity->toArray();
    }
}