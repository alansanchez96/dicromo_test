<?php

namespace Src\Modules\Auth\Infrastructure\Repositories;

use Src\Common\BaseRepository;
use Illuminate\Support\Facades\DB;
use Src\Modules\Auth\Domain\Entities\UserEntity;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Src\Modules\Auth\Domain\Contracts\IRegisterRepository;
use Src\Modules\Auth\Infrastructure\Exceptions\AuthException;

class RegisterRepository extends BaseRepository implements IRegisterRepository
{
    public function register(array $entity): bool|AuthDB
    {
        try {
            DB::beginTransaction();

            $auth = AuthDB::create([
                'name'      => $this->capitalized($entity['name']),
                'email'     => $this->lower($entity['email']),
                'password'  => $this->stringHash($entity['password']),
            ]);

            if (!$auth) throw new AuthException('Ha ocurrido un error', 421);

            return $auth;
        } catch (AuthException $e) {
            DB::rollBack();
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return false;
        }
    }
}
