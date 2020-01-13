<?php

namespace Leuverink\Lockdown;

use Illuminate\Support\Collection;
use Leuverink\Lockdown\Drivers\Driver;
use Leuverink\Lockdown\Exceptions\LockdownDriverNotFound;

class DriverFactory
{
    private $guard;

    public function __construct($guard)
    {
        $this->guard = new Collection($guard);
    }

    /**
     * Create a Driver instance.
     *
     * @return \Leuverink\Lockdown\Drivers\Driver
     */
    public function build(): Driver
    {
        $arguments = $this->resolveDriverArguments();

        // Check if the configured driver exists
        $driver = $this->resolveDriverPath();
        if (class_exists($driver)) {
            return new $driver($arguments);
        }

        // If not a Lockdown driver it means it is a custom driver
        $driver = $this->guard->get('driver');
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
        $driverClassName = ucfirst($this->guard->get('driver'));

        return sprintf('\\%s\\Drivers\\%sDriver', __NAMESPACE__, $driverClassName);
    }

    /**
     * Resolves the driver's arguments from the guard.
     *
     * @return void
     */
    private function resolveDriverArguments()
    {
        return $this->guard->except('driver')->toArray() ?? null;
    }
}
