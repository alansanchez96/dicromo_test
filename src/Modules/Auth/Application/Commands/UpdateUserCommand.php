<?php

namespace Src\Modules\Auth\Application\Commands;

use Illuminate\Http\Request;
use Src\Common\UseCases;
use Src\Modules\Auth\Domain\Entities\UserEntity;
use Src\Common\Exceptions\InvalidPasswordException;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Src\Modules\Auth\Domain\Contracts\IUserRepository;

class UpdateUserCommand extends UseCases
{
    public function __construct(private readonly IUserRepository $repository) { parent::__construct(); }

    public function updateUser(AuthDB $auth, Request $rq)
    {   
        $entity = $this->getEntity($rq);

        if (isset($entity['name']) && $entity['name'] !== $auth->name)
            $this->repository->updateName($auth, $entity['name']);

        if (isset($entity['email']) && $entity['email'] !== $auth->email)
            $this->repository->updateEmail($auth, $entity['email']);

        if (isset($entity['password']) && !password_verify($entity['password'], $auth->password))
            $this->repository->updatePassword($auth, $entity['password']);

        return $auth;
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