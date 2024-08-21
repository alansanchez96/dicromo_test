<?php

namespace Src\Modules\Auth\Application\Commands;

use Src\Common\UseCases;
use Src\Modules\Auth\Domain\Contracts\ILoginRepository;
use Src\Modules\Auth\Domain\Contracts\IUserRepository;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;

class DeleteUserCommand extends UseCases
{
    public function __construct(private readonly IUserRepository $userRepository, private readonly ILoginRepository $loginRepository) { parent::__construct(); }

    public function deleteUser(AuthDB $auth)
    {
        $deleteStatus = $this->userRepository->delete($auth);

        if ($deleteStatus == 422) return $deleteStatus;
        
        if ($deleteStatus == 200) return $this->loginRepository->logout();
    }
}