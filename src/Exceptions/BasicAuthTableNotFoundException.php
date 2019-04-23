<?php

namespace Gwleuverink\Lockdown\Exceptions;

use Exception;

class BasicAuthTableNotFoundException extends Exception 
{
    public function __construct ()
    {
        parent::__construct(
            "BasicLock database table not found. Publish and migrate the package migrations or use the config driver instead.", 
            $code = 0 , 
            $previous = NULL
        );
    }
}