<?php

namespace Src\Modules\Auth\Domain\Contracts;

use Src\Modules\Auth\Domain\Entities\UserEntity;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;

interface IUserRepository
{
    public function get(): AuthDB|int;

    public function updateName(AuthDB $auth, string $name): void;

    public function updateEmail(AuthDB $auth, string $email): void;

    public function updatePassword(AuthDB $auth, string $password): void;

    public function delete(AuthDB $auth): int;
}