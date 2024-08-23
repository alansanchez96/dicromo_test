<?php

namespace Src\Modules\Tasks\Application\Command;

use Src\Common\UseCases;
use Illuminate\Http\Request;
use Src\Common\Interfaces\Laravel\EloquentModel;
use Src\Modules\Tasks\Domain\Contracts\ITaskRepository;
use Src\Modules\Tasks\Domain\Domain\Entities\TaskEntity;

class TaskCreateCommand extends UseCases
{
    public function __construct(private readonly ITaskRepository $repository) { parent::__construct(); }

    public function createTask(Request $rq)
    {
        $entity = $this->getEntity($rq);

        return $this->repository->create($entity);
    }

    public function getEntity(Request $rq, EloquentModel $model = null)
    {
        $entity = new TaskEntity;

        $entity->setUserId($rq->user_id);
        $entity->setName($rq->name);
        $entity->setDescription($rq->description);
        $entity->setStatus($rq->status);

        return $entity->toArray();
    }
}