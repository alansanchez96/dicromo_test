<?php

namespace Src\Common\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Src\Common\Exceptions\LogException;
use Src\Shared\LoggerDB;

class LogService
{
    public function create(array $log): void
    {
        try {
            $log = LoggerDB::create($log);

            if (!$log) throw new LogException('ERROR AL CREAR EL LOG');
        } catch (LogException $e) {
            DB::rollBack();
            Log::channel('logger')->debug('LogsException', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'exception' => $e
            ]);
        }
    }
}
