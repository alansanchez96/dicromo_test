<?php

use Illuminate\Support\Facades\Route;
use Src\Modules\Tasks\Infrastructure\Controllers\TaskDelete;
use Src\Modules\Tasks\Infrastructure\Controllers\{TaskCreate, TasksCollection, TaskUpdate};

Route::middleware('auth:api')->group(function () {
    Route::get('/', TasksCollection::class);
    Route::post('/', TaskCreate::class);
    Route::put('/{id}', TaskUpdate::class);
    Route::delete('/{id}', TaskDelete::class);
});
