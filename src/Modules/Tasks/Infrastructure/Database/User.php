<?php

namespace Src\Modules\Tasks\Infrastructure\Database;

use Database\Factories\UserFactory;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AuthDB
{
    use HasFactory;

    protected $collection = 'users';

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
