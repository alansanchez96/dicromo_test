<?php

namespace Src\Modules\Auth\Infrastructure\Repositories;

use Src\Common\BaseRepository;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Src\Modules\Auth\Domain\Contracts\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function get(): AuthDB|int
    {
        try {
            $user = auth()->userOrFail();

            return $user;
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);
            return 422;
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return 422;
        }
    }

    public function updateName(AuthDB $auth, string $name): void
    {
        $auth->update([ 'name' => $this->capitalized($name) ]);
    }

    public function updateEmail(AuthDB $auth, string $email): void
    {
        $auth->update([ 'email' => $this->lower($email) ]);
    }

    public function updatePassword(AuthDB $auth, string $password): void
    {
        $auth->update([ 'password' => $this->stringHash($password) ]);
    }

    public function delete(AuthDB $auth): int
    {
        try {
            $auth->delete();

            return 200;
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return 422;
        }
    }
}
