<?php

declare(strict_types=1);

namespace App\Exceptions\Authentication;

use Exception;
use Throwable;

class InvalidPasswordException extends Exception
{
    public function __construct($message = "Invalid password", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
