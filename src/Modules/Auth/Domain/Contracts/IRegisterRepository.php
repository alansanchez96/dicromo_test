<?php

namespace Src\Modules\Auth\Domain\Contracts;

use Src\Modules\Auth\Domain\Entities\UserEntity;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;

interface IRegisterRepository
{
    public function register(array $entity): bool|AuthDB;
}