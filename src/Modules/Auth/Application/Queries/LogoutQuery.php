<?php

namespace Src\Modules\Auth\Application\Queries;

use Src\Common\UseCases;
use Src\Modules\Auth\Domain\Contracts\ILoginRepository;

class LogoutQuery extends UseCases
{
    public function __construct(private readonly ILoginRepository $repository) {}

    public function execute(): int
    {
        return $this->repository->logout();
    }
}
