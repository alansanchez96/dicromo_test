<?php

namespace Src\Common;

use Illuminate\Http\Request;
use Src\Common\Services\LogService;
use Src\Common\Interfaces\Laravel\EloquentModel;

abstract class UseCases
{
    protected $log;

    public function __construct()
    {
        $this->log = new LogService();
    }

    abstract public function getEntity(Request $rq, EloquentModel $model = null);
}
