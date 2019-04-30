<?php

namespace Gwleuverink\Lockdown\Contracts;

use Illuminate\Http\Request;

interface DriverContract
{
    public function __construct($arguments);

    /**
     * Check if current request passes the
     * BasicLock authentication guard.
     *
     * @return bool
     */
    public function passesAuthentication($user, $password) : bool;
}
