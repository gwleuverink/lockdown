<?php

namespace Leuverink\Lockdown\Drivers;

class ConfigDriver extends Driver
{
    /**
     * Check if current request passes the
     * BasicLock authentication guard.
     *
     * @return bool
     */
    public function passesAuthentication($user, $password) : bool
    {

        $passes = collect($this->users)->filter(function ($authenticatable) use ($user, $password) {
            return $authenticatable['user'] === $user &&
                   $authenticatable['password'] === $password;
        })->isNotEmpty();

        return $passes;
    }
}
