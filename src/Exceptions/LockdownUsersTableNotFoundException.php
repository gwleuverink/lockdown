<?php

namespace Gwleuverink\Lockdown\Exceptions;

use Exception;

class LockdownUsersTableNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Lockdown users table not found. Publish and migrate lockdown migrations or use the config driver instead.");
    }
}
