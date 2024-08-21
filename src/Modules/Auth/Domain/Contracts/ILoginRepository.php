<?php

namespace Src\Modules\Auth\Domain\Contracts;

interface ILoginRepository
{
    public function attemptLogin(array $entity): bool|array;

    public function logout(): int;
}