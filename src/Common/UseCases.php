<?php

namespace Src\Common;

use Src\Common\Services\LogService;

abstract class UseCases
{
    protected $log;

    public function __construct()
    {
        $this->log = new LogService();
    }
}
