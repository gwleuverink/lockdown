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
        if (!$this->hasCredentials()) {
            return false;
        }

        $passes = $this->arguments->filter(function ($authenticatable) {
            return $authenticatable['user'] === $this->getProvidedUser() &&
                   $authenticatable['password'] === $this->getProvidedPassword();
        })->isNotEmpty();

        return $passes;
    }
}
