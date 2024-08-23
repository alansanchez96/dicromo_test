<?php

namespace Src\Common\Providers\Tasks;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Src\Modules\Tasks\Domain\Contracts\ITaskRepository;
use Src\Modules\Tasks\Infrastructure\Repositories\TaskRepository;

class TaskServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->map();
    }

    public function register()
    {
        $this->app->bind(ITaskRepository::class, TaskRepository::class);
    }

    private function map()
    {
        $this->mapApiRoutes();
    }

    private function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api/tasks')
            ->group(base_path('src/Modules/Tasks/Infrastructure/api_tasks.php'));
    }
}
