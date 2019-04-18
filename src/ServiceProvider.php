<?php

namespace Gwleuverink\Lockdown;

use Gwleuverink\Lockdown\BasicLockFactory;
use Gwleuverink\Lockdown\Middleware\BasicLockGuard;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->router->aliasMiddleware('lockdown', BasicLockGuard::class);

        $this->publishes([ __DIR__ . '/../config/basic-auth.php' => base_path('config/basic-auth.php') ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/basic-auth.php', 'basic-auth');
        
        $this->app->bind(BasicLockFactory::class, function ($app) {
            return new BasicLockFactory($app);
        });

    }
}
