<?php 

namespace Gwleuverink\Lockdown;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;
use \Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

class BasicLockFactory {

    private $app;
    public $config;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->loadConfig();
    }

    public function build(Request $request) 
    {
        return new BasicLock($request, $this->config);
    }

    private function loadConfig()
    {
        $this->config = new ConfigRepository($this->app->config->get('basic-auth'));
    }
}