<?php

namespace Src\Modules\Tasks\Application\Queries;

use Src\Common\UseCases;
use Illuminate\Http\Request;
use Src\Common\Interfaces\Laravel\EloquentModel;
use Src\Modules\Tasks\Domain\Contracts\ITaskRepository;
use Src\Modules\Tasks\Domain\Domain\Entities\TaskEntity;

class GetTasksQuery extends UseCases
{
    public function __construct(private readonly ITaskRepository $repository) { parent::__construct(); }

    public function getTask(Request $rq)
    {
        $entity = $this->getEntity($rq);

        if (isset($entity['id']))
            return $this->repository->getById($entity);

//         $filters = [];
//         $allowedKeys = ['user_id', 'name', 'description', 'status'];

//         foreach ($rq->input() as $key => $value) {
//             if (in_array($key, array_keys($entity))) {
//                 $value = (in_array($key, $allowedKeys))
//                     ? $value = [$key, $value]
//                     : $value = [$key, 'like', "%" . $value . "%"];

//                 array_push($filters, $value);
//             }
//         }

//         return $this->repository->get($filters);
    }

    public function getTasksCollection(Request $rq)
    {
        $entity = $this->getEntity($rq);

        return $this->repository->collection($entity);
    }

    public function getEntity(Request $rq, EloquentModel $model = null)
    {
        $entity = new TaskEntity;
        $entity->setUserId($rq->user_id);

        if (isset($rq->id)) {
            $entity->setId($rq->id);
            
            return $entity->toArray();
        }

        if (isset($rq->status)) $entity->setStatus($rq->status);

        if (isset($rq->name)) $entity->setName($rq->name);

        if (isset($rq->description)) $entity->setDescription($rq->description);

        return $entity->toArray();
    }
}