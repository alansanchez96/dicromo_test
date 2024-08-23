<?php

namespace Src\Common\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();
        $this->mapApiRoutes();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    private function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/tasks')
            // ->namespace($this->namespace)
            ->group(base_path('src/Modules/Tasks/Infrastructure/api_tasks.php'));
    }

}
