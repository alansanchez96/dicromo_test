<?php

namespace Src\Common\Interfaces\Laravel;

use Illuminate\Routing\Controller;
use Src\Common\Services\{ApiResponseService, LogService};

abstract class LaravelController extends Controller
{
    protected $log, $response;

    public function __construct()
    {
        $this->log = new LogService();
        $this->response = new ApiResponseService();
    }
}