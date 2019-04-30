<?php

namespace Gwleuverink\Lockdown\Drivers;

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
        $passes = $this->arguments->filter(function ($authenticatable) use ($user, $password) {
            return $authenticatable['user'] === $user &&
                   $authenticatable['password'] === $password;
        })->isNotEmpty();

        return $passes;
    }
}
