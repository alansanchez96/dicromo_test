<?php

namespace Src\Common\Contracts;

use Illuminate\Http\Request;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

interface LogContract
{
    public function setLog(Request $request, ?MongoModel $model, ?MongoModel $previousModel = null, string $typeOperation = 'create'): array;

    public function setErrorLog(Request $request, \Exception $e): array;
}