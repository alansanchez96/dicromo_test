<?php

namespace Src\Common\Providers\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Src\Modules\Auth\Domain\Contracts\IUserRepository;
use Src\Modules\Auth\Domain\Contracts\ILoginRepository;
use Src\Modules\Auth\Domain\Contracts\IRegisterRepository;
use Src\Modules\Auth\Infrastructure\Repositories\UserRepository;
use Src\Modules\Auth\Infrastructure\Repositories\LoginRepository;
use Src\Modules\Auth\Infrastructure\Repositories\RegisterRepository;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->map();
    }

    public function register()
    {
        $this->app->bind(ILoginRepository::class, LoginRepository::class);
        $this->app->bind(IRegisterRepository::class, RegisterRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }

    private function map()
    {
        $this->mapApiRoutes();
    }

    private function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/auth')
            ->group(base_path('src/Modules/Auth/Infrastructure/api_auth.php'));
    }
}
