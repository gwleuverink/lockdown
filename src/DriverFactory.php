<?php

namespace Gwleuverink\Lockdown;

use Illuminate\Http\Request;
use Gwleuverink\Lockdown\Exceptions\LockdownDriverNotFound;
use Gwleuverink\Lockdown\Drivers\Driver;

class DriverFactory
{
    private $request;
    private $guard;

    public function __construct(Request $request, object $guard)
    {
        $this->request = $request;
        $this->guard = $guard;
    }


    /**
     * Create a Driver instance
     *
     * @return \Gwleuverink\Lockdown\Drivers\Driver
     */
    public function build() : Driver
    {
        $driver = $this->resolveDriverPath();
        $arguments = $this->resolveDriverArguments();

        if (! class_exists($driver)) {
            throw new LockdownDriverNotFound($driver);
        }

        return new $driver($this->request, $arguments);
    }


    /**
     * Resolves the driver's path from the guard
     *
     * @return string
     */
    private function resolveDriverPath()
    {
        return sprintf('\\%s\\Drivers\\%sDriver', __NAMESPACE__, ucfirst($this->guard->driver));
    }

    
    /**
     * Resolves the driver's arguments from the guard
     *
     * @return void
     */
    private function resolveDriverArguments()
    {
        return $this->guard->arguments ?? null;
    }
}
