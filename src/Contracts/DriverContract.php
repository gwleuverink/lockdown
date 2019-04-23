<?php

namespace Gwleuverink\Lockdown\Contracts;

use Illuminate\Http\Request;

interface DriverContract
{
    public function __construct(Request $request, $arguments);
    
    /**
     * Check if current request passes the
     * BasicLock authentication guard
     * 
     * @return boolean
     */
    public function authenticate() : bool;
}