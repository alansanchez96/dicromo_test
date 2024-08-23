<?php

namespace Src\Modules\Tasks\Infrastructure\Database;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Common\Interfaces\Laravel\EloquentModel;

class Task extends EloquentModel
{
    use HasFactory;

    protected $collection = 'tasks';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function newFactory()
    {
        return TaskFactory::new();
    }
}