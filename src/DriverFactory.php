<?php

namespace Leuverink\Lockdown;

use Leuverink\Lockdown\Drivers\Driver;
use Leuverink\Lockdown\Exceptions\LockdownDriverNotFound;
use Illuminate\Support\Fluent;

class DriverFactory
{

    private $guard;

    public function __construct($guard)
    {
        $this->guard = new Fluent($guard);
    }

    /**
     * Create a Driver instance.
     *
     * @return \Leuverink\Lockdown\Drivers\Driver
     */
    public function build() : Driver
    {
        $arguments = $this->resolveDriverArguments();

        // Check if the configured driver exists
        $driver = $this->resolveDriverPath();
        if (class_exists($driver)) {
            return new $driver($arguments);
        }

        // If not a Lockdown driver it means it is a custom driver
        $driver = $this->guard->driver;
        if (class_exists($driver)) {
            return new $driver($arguments);
        }

        // Well that doesn't work now does it
        throw new LockdownDriverNotFound($driver);
    }

    /**
     * Resolves the driver's path from the guard.
     *
     * @return string
     */
    private function resolveDriverPath()
    {
        return sprintf('\\%s\\Drivers\\%sDriver', __NAMESPACE__, ucfirst($this->guard->driver));
    }

    /**
     * Resolves the driver's arguments from the guard.
     *
     * @return void
     */
    private function resolveDriverArguments()
    {
        return $this->guard->arguments ?? null;
    }
}
