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
     * Spin up a new driver and verify the request
     *
     * @param string $guardName
     * @return bool
     */
    public function verifyRequest($guardName)
    {
        $driver = (new DriverFactory($this->request, $this->getGuard()))->build();

        return $driver->verifyRequest();
    }

    /**
     * Get the current guard section from the config
     *
     * @return object
     */
    private function getGuard()
    {
        $guardName = $guardName ?? $this->config->get('default');
        return (object) $this->config->get("guards.$guardName");
    }
}
