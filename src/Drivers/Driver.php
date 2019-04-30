<?php

namespace Gwleuverink\Lockdown\Drivers;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Gwleuverink\Lockdown\Contracts\DriverContract;

abstract class Driver implements DriverContract
{

    /**
     * All optional arguments passed via the guard config
     *
     * @var Collection
     */
    protected $arguments;

    public function __construct($arguments)
    {
        $this->arguments = new Collection($arguments);
    }

    /**
     * Wrapper method for the driver's passesAuthentication() method
     * This method is called by Lockdown to verify authentication
     * against the configured guard.
     *
     * @throws UnauthorizedHttpException
     * @return bool
     */
    final public function verifyRequest($user, $password) : bool
    {
        throw_unless(
            $user && $password,
            UnauthorizedHttpException::class,
            'Basic',
            'Invalid Credentials'
        );

        throw_unless(
            $passes = $this->passesAuthentication($user, $password),
            UnauthorizedHttpException::class,
            'Basic',
            'Invalid credentials.'
        );

        return $passes;
    }
}
