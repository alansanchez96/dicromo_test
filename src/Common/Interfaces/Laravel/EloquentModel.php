<?php

namespace Src\Common\Interfaces\Laravel;

use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model as MongoModel;

abstract class EloquentModel extends MongoModel
{
    // use SoftDeletes;

    protected $connection = 'mongodb';
}