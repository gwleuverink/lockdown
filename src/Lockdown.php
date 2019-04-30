<?php

namespace Leuverink\Lockdown;

use Illuminate\Http\Request;
use Illuminate\Config\Repository as ConfigRepository;

class Lockdown
{
    /**
     * The current request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * The guard configuration.
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
     * Spin up a new driver and verify the request against the given guard.
     *
     * @param string $guardName
     * @return bool
     */
    public function verifyRequest($guardName = null)
    {
        $driver = (new DriverFactory($this->getGuard($guardName)))->build();

        return $driver->verifyRequest($this->getProvidedUser(), $this->getProvidedPassword());
    }

    /**
     * Get the current guard section from the config.
     *
     * @return object
     */
    private function getGuard($guardName)
    {
        $guardName = $guardName ?? $this->config->get('default');

        return (object) $this->config->get("guards.$guardName");
    }

    /**
     * Fetch the user entry from the request.
     *
     * @return string
     */
    final protected function getProvidedUser()
    {
        return $this->request->server->get('PHP_AUTH_USER');
    }

    /**
     * Fetch the password entry from the request.
     *
     * @return string
     */
    final protected function getProvidedPassword()
    {
        return $this->request->server->get('PHP_AUTH_PW');
    }
}
