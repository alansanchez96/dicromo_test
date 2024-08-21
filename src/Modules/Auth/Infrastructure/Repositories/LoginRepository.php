<?php

namespace Src\Modules\Auth\Infrastructure\Repositories;

use Src\Common\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Src\Modules\Auth\Domain\Contracts\ILoginRepository;

class LoginRepository extends BaseRepository implements ILoginRepository
{
    public function attemptLogin(array $entity): bool|array
    {
        try {
            $credentials = [
                'email' => $entity['email'],
                'password' => $entity['password']
            ];

            $token = Auth::attempt($credentials);

            return !$token ? $token : $this->respondWithToken($token);
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);

            return false;
        }
    }

    private function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }

    public function logout(): int
    {
        try {
            $auth = Auth::user();

            if (!$auth) return 422;

            auth()->logout(true);

            return 200;
        } catch (\Exception $e) {
            $this->log->create(['class' => self::class, 'line' => $e->getLine()]);
        }
    }
}
