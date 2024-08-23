<?php

namespace Src\Shared;

use Src\Common\Interfaces\Laravel\EloquentModel;

class LoggerDB extends EloquentModel 
{
    protected $collection = 'error_logs';

    protected $fillable = [
        'class',
        'line',
    ];
}