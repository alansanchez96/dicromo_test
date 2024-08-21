<?php

namespace Src\Modules\Auth\Application\Commands;

use Illuminate\Http\Request;
use Src\Common\UseCases;
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

    private function getEntity(Request $rq): array
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