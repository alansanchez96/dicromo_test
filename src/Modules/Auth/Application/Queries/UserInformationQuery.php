<?php

namespace Src\Modules\Auth\Application\Queries;

use Src\Common\UseCases;
use Illuminate\Http\Request;
use Src\Common\Interfaces\Laravel\EloquentModel;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Src\Modules\Auth\Domain\Contracts\IUserRepository;

class UserInformationQuery extends UseCases
{
    public function __construct(private readonly IUserRepository $repository) { parent::__construct(); }

    public function execute(): AuthDB|int
    {
        return $this->repository->get();
    }

    public function getEntity(Request $rq, EloquentModel $model = null)
    {
        
    }
}
