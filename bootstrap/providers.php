<?php

use Src\Common\Providers\Tasks\TaskServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    Src\Common\Providers\Auth\AuthServiceProvider::class,
    TaskServiceProvider::class,
    
    // Packages
    MongoDB\Laravel\MongoDBServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
];
