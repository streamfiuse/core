<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotCreatedException extends Exception
{
    public function __construct($message = "Could not be created!", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
