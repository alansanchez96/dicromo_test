<?php

return [
    App\Providers\AppServiceProvider::class,
    Src\Common\Providers\Auth\AuthServiceProvider::class,
    Src\Common\Providers\RouteServiceProvider::class,

    // Packages
    MongoDB\Laravel\MongoDBServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
];
