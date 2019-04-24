<?php

namespace Gwleuverink\Lockdown\Exceptions;

use Exception;

class LockdownDriverNotFound extends Exception
{
    public function __construct($className)
    {
        parent::__construct("Driver with class $className not found. Please check if your BasicLock config is valid");
    }
}
