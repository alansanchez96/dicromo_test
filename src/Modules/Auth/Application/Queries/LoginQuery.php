<?php

namespace Src\Modules\Auth\Application\Queries;

use Illuminate\Http\Request;
use Src\Common\UseCases;
use Src\Modules\Auth\Domain\Entities\UserEntity;
use Src\Modules\Auth\Domain\Contracts\ILoginRepository;

class LoginQuery extends UseCases
{
    public function __construct(private readonly ILoginRepository $repository) { parent::__construct(); }

    public function login(Request $rq): array|bool
    {
        try {
            $entity = $this->getEntity($rq);

            $response = $this->repository->attemptLogin($entity);

            return is_array($response)
                ?   $response
                :   throw new \InvalidArgumentException('Invalid credentials', 401);
        } catch (\InvalidArgumentException $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return false;
        }
    }

    private function getEntity(Request $rq): array
    {
        $entity = new UserEntity();

        if (isset($rq->email))
            $entity->setEmail($rq->email);

        if (isset($rq->password))
            $entity->setPassword($rq->password);

        return $entity->toArray();
    }
}
