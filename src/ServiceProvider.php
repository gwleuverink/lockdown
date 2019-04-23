<?php

namespace Gwleuverink\Lockdown;

use Gwleuverink\Lockdown\BasicLockFactory;
use Gwleuverink\Lockdown\Middleware\BasicLockGuard;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Boot middleware
        $this->app->router->aliasMiddleware('lockdown', BasicLockGuard::class);

        // Publish config
        $this->publishes([
             __DIR__ . '/../config/basic-auth.php' => base_path('config/basic-auth.php') 
        ], 'config');

        // Publish migrations
        if(! class_exists('CreateBasicAuthUsersTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_basic_auth_users_table.php.stub' => 
                database_path('migrations/' . date('Y_m_d_His', time()) . '_create_basic_auth_users_table.php')
            ], 'migrations');
        }
        
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/basic-auth.php', 'basic-auth');
        
        // Register implementations
        $this->app->bind(BasicLockFactory::class, function ($app) {
            return new BasicLockFactory($app);
        });
    }
}
