<?php

namespace App\Exceptions;

use Exception;

class CredentialsMismatchException extends Exception
{
    public function __construct($message = null)
    {
        $message = $message ?? 'These credentials do not match our records';
        parent::__construct($message, 401);
    }
}
