<?php

namespace Gwleuverink\Lockdown\Exceptions;

use Exception;

class DriverNotFoundException extends Exception 
{
    public function __construct ($message = "", $code = 0 , $previous = NULL)
    {
        parent::__construct(
            "Driver with class $message not found. Please check if your BasicLock config is valid", 
            $code = 0 , 
            $previous = NULL
        );
    }
}