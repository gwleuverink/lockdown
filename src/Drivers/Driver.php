<?php

namespace Gwleuverink\Lockdown\Drivers;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Gwleuverink\Lockdown\Contracts\DriverContract;

abstract class Driver implements DriverContract
{
    /**
     * The current request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * All optional arguments passed via the guard config
     *
     * @var Collection
     */
    protected $arguments;


    public function __construct(Request $request, $arguments)
    {
        $this->request = $request;
        $this->arguments = new Collection($arguments);
    }

    public final function verifyRequest()
    {
        if(! config('lockdown.middleware-enabled')) return;

        throw_unless(
            $this->hasCredentials(),
            UnauthorizedHttpException::class,
            'Basic', 'Invalid Credentials'
        );

        throw_unless(
            $passes =  $this->passesAuthentication(),
            UnauthorizedHttpException::class,
            'Basic', 'Invalid credentials.'
        );

        return $passes;
    }

    /**
     * Fetch the user entry from the request
     *
     * @return string
     */
    final protected function getProvidedUser()
    {
        return $this->request->server->get('PHP_AUTH_USER');
    }


    /**
     * Fetch the password entry from the request
     *
     * @return string
     */
    final protected function getProvidedPassword()
    {
        return $this->request->server->get('PHP_AUTH_PW');
    }

    
    /**
     * Checks if the the current request has
     * both user and password fields filled
     *
     * @return boolean
     */
    final protected function hasCredentials() : bool
    {
        return $this->getProvidedUser() && $this->getProvidedPassword();
    }
}
