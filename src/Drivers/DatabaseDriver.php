<?php

namespace Gwleuverink\Lockdown\Drivers;

class ConfigDriver extends Driver
{
    /**
     * Check if current request passes the
     * BasicLock authentication guard
     *
     * @return boolean
     */
    public function authenticate() : bool
    {
        return false;
    }
}