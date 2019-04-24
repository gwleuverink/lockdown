<?php

namespace Gwleuverink\Lockdown;

use Illuminate\Http\Request;
use Illuminate\Config\Repository as ConfigRepository;
use Gwleuverink\Lockdown\Exceptions\LockdownDriverNotFound;
use Gwleuverink\Lockdown\Contracts\DriverContract;

class Lockdown
{
    /**
     * The current request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * The guard configuration
     *
     * @var ConfigRepository
     */
    public $config;

    public function __construct(Request $request, ConfigRepository $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function verifyRequest($guardName)
    {
        // TODO: Extract to driver factory
        $guardName = $guardName ?? $this->config->get('default');
        $guard = (object) $this->config->get("guards.$guardName");
        $driverFqcn = sprintf('\\%s\\Drivers\\%sDriver', __NAMESPACE__, ucfirst($guard->driver));
        $passes =  $this->getDriver($driverFqcn, $guard->arguments ?? null)->verifyRequest();

        return $passes;
    }

    /**
     * Build a driver instance
     *
     * @param string $driver
     * @param object $arguments
     * @return DriverContract
     */
    private function getDriver($driver, $arguments = null) : DriverContract
    {
        // TODO: maybe this should live in a factory
        if (! class_exists($driver)) {
            throw new LockdownDriverNotFound($driver);
        }

        return new $driver($this->request, $arguments);
    }
}
