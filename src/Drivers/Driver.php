<?php

namespace Leuverink\Lockdown\Drivers;

use Illuminate\Support\Collection;
use Leuverink\Lockdown\Contracts\DriverContract;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

abstract class Driver implements DriverContract
{

    public function __construct($properties)
    {
        $this->setObjectProperties($properties);
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

    /**
     * Set the instance public properties dynamically
     *
     * @param array$properties
     * @return void
     */
    final private function setObjectProperties(array $properties)
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }
}
