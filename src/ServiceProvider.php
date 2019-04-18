<?php

namespace Gwleuverink\Lockdown;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Gwleuverink\Lockdown\Http\Middleware\AccessGuard;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->registerMiddleware();
    }

    public function register()
    {
        
    }

    private function registerMiddleware()
    {
        $this->app->router->aliasMiddleware(
            'lockdown', \Gwleuverink\Lockdown\Http\Middleware\BasicAccessGuard::class
        );
    }
}
