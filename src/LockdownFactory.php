<?php

namespace Gwleuverink\Lockdown;

use Illuminate\Contracts\Foundation\Application;
use \Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

class LockdownFactory
{

    /**
     * The application container
     *
     * @var Application
     */
    private $app;

    /**
     * The lockdown configuration
     *
     * @var ConfigRepository
     */
    public $config;


    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->loadConfig();
    }

    /**
     * Return a BasicLock instance
     *
     * @param Request $request
     * @return Lockdown
     */
    public function build(Request $request)
    {
        return new Lockdown($request, $this->config);
    }

    /**
     * Load lockdown configuration
     *
     * @return void
     */
    private function loadConfig()
    {
        $this->config = new ConfigRepository($this->app->config->get('lockdown'));
    }
}
