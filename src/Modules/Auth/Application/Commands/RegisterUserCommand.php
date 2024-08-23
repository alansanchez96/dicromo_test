<?php

namespace Src\Modules\Auth\Application\Commands;

use Src\Common\UseCases;
use Illuminate\Http\Request;
use Src\Common\Interfaces\Laravel\EloquentModel;
use Src\Modules\Auth\Domain\Entities\UserEntity;
use Src\Modules\Auth\Domain\Contracts\IRegisterRepository;

class RegisterUserCommand extends UseCases
{
    public function __construct(private readonly IRegisterRepository $repository) { parent::__construct(); }

    public function registerAUser(Request $rq)
    {
        $entity = $this->getEntity($rq);

        return $this->repository->register($entity);
    }

    public function getEntity(Request $rq, EloquentModel $model = null): array
    {
        $entity = new UserEntity();

        if (isset($rq->email))
            $entity->setEmail($rq->email);
    
        if (isset($rq->name))
            $entity->setName($rq->name);

        if (isset($rq->password))
            $entity->setPassword($rq->password);

        return $entity->toArray();
    }
}