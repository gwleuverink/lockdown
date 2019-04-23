<?php

namespace Gwleuverink\Lockdown\Drivers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Gwleuverink\Lockdown\Contracts\DriverContract;

abstract class Driver implements DriverContract
{
    protected $arguments;
    protected $request;

    public function __construct(Request $request, $arguments)
    {
        $this->request = $request;
        $this->arguments = new Collection($arguments);
    }

    /**
     * Fetch the user entry from the request
     *
     * @return string
     */
    protected function getProvidedUser()
    {   
        return $this->request->server->get('PHP_AUTH_USER');
    }

    /**
     * Fetch the password entry from the request
     *
     * @return string
     */
    protected function getProvidedPassword()
    {        
        return $this->request->server->get('PHP_AUTH_PW');
    }

    /**
     * Checks if the the current request has 
     * both user and password fields filled
     *
     * @return boolean
     */
    protected function hasCredentials() : bool
    {
        return ($this->getProvidedUser() && $this->getProvidedPassword());
    }
}