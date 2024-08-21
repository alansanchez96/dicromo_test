<?php

namespace Src\Common\Exceptions;

class LogException extends \Exception
{
    public function __construct(
        $message = 'ErrorLogs',
        $code = 500,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
