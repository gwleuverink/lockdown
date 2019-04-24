<?php

namespace Gwleuverink\Lockdown;

use Illuminate\Http\Request;
use Gwleuverink\Lockdown\Exceptions\LockdownDriverNotFound;
use Gwleuverink\Lockdown\Drivers\Driver;

class DriverFactory {

    private $request;
    private $guard;

    public function __construct(Request $request, object $guard)
    {
        $this->request = $request;
        $this->guard = $guard;
    }


    public function build() : Driver
    {
        $driver = $this->resolveDriverPath();
        $arguments = $this->resolveDriverArguments();

        if (! class_exists($driver)) {
            throw new LockdownDriverNotFound($driver);
        }

        return new $driver($this->request, $arguments);
    }


    private function resolveDriverPath()
    {
        return sprintf('\\%s\\Drivers\\%sDriver', __NAMESPACE__, ucfirst($this->guard->driver));
    }

    
    private function resolveDriverArguments()
    {
        return $this->guard->arguments ?? null;
    }
}