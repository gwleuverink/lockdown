<?php

namespace Gwleuverink\Lockdown;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;
use \Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

class BasicLockFactory
{

    /**
     * The application container
     *
     * @var Application
     */
    private $app;

    /**
     * The basic-lock configuration
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
     * @return BasicLock
     */
    public function build(Request $request)
    {
        return new BasicLock($request, $this->config);
    }

    /**
     * Load basic-lock configuration
     *
     * @return void
     */
    private function loadConfig()
    {
        $this->config = new ConfigRepository($this->app->config->get('basic-lock'));
    }
}
