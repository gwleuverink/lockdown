<?php

namespace Gwleuverink\Lockdown\Exceptions;

use Exception;

class LockdownUsersTableNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct("Lockdown users table not found. Publish and migrate lockdown migrations or use the config driver instead.");
    }
}
