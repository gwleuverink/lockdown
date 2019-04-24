<?php

namespace Gwleuverink\Lockdown\Drivers;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ConfigDriver extends Driver
{
    /**
     * Check if current request passes the
     * BasicLock authentication guard
     *
     * @throws UnauthorizedHttpException
     * @return boolean
     */
    public function authenticate() : bool
    {
        throw_unless(
            $this->hasCredentials(),
            UnauthorizedHttpException::class,
            'Basic'
        );

        $passes = $this->arguments->filter(function ($authenticatable) {
            return $authenticatable['user'] === $this->getProvidedUser() &&
                   $authenticatable['password'] === $this->getProvidedPassword();
        })->isNotEmpty();

        throw_unless(
            $passes,
            UnauthorizedHttpException::class,
            'Basic'
        );

        return $passes;
    }
}
