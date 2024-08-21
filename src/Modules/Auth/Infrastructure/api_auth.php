<?php

use Illuminate\Support\Facades\Route;
use Src\Modules\Auth\Infrastructure\Controllers\{Authentication, DeleteUser, Information, InformationUpdate, Register, Logout };

Route::post('/login', Authentication::class);
Route::post('/register', Register::class);

Route::middleware(['auth:api'])->group(function() {
    Route::post('/logout', Logout::class);
    Route::post('/user', Information::class);
    Route::put('/user', InformationUpdate::class);
    Route::delete('/user', DeleteUser::class);
});