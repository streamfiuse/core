<?php

declare(strict_types=1);

namespace App\Exceptions\Authentication;

use Exception;
use Throwable;

class UserNotFoundException extends Exception
{
    public function __construct($message = "No user with such email address", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
