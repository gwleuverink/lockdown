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

    /**
     * Check if current request passes the
     * BasicLock authentication guard
     *
     * @param string $guardName
     * @return boolean
     */
    public function authenticates($guardName) : bool
    {
        $guardName = $guardName ?? $this->config->get('default');

        $guard = (object) $this->config->get("guards.$guardName");
        $driverFqcn = sprintf('\\%s\\Drivers\\%sDriver', __NAMESPACE__, ucfirst($guard->driver));

        return $this->getDriver($driverFqcn, $guard->arguments ?? null)->authenticate();
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
        if (! class_exists($driver)) {
            throw new LockdownDriverNotFound($driver);
        }

        return new $driver($this->request, $arguments);
    }
}
