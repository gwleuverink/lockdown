<?php

namespace Gwleuverink\Lockdown\Drivers;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ConfigDriver extends Driver
{
    /**
     * Check if current request passes the
     * BasicLock authentication guard
     *
     * @return boolean
     */
    public function passesAuthentication() : bool
    {
        $passes = $this->arguments->filter(function ($authenticatable) {
            return $authenticatable['user'] === $this->getProvidedUser() &&
                   $authenticatable['password'] === $this->getProvidedPassword();
        })->isNotEmpty();

        return $passes;
    }
}
