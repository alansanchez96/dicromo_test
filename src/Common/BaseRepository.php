<?php

namespace Src\Common;

use Src\Common\Traits\Hasher;
use Src\Common\Traits\Converter;
use Src\Common\Services\LogService;

abstract class BaseRepository
{
    use Hasher, Converter;

    protected $log;

    public function __construct()
    {
        $this->log = new LogService;
    }
}