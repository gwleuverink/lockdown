<?php

namespace Gwleuverink\Lockdown;

use Gwleuverink\Lockdown\BasicLockFactory;
use Gwleuverink\Lockdown\Middleware\BasicLockGuard;
use Gwleuverink\Lockdown\Commands\CreateDatabaseUser;
use Gwleuverink\Lockdown\Commands\DeleteDatabaseUser;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Boot middleware
        $this->app->router->aliasMiddleware('lockdown', BasicLockGuard::class);

        // Boot commands
        if($this->app->runningInConsole()) {
            $this->commands([
                CreateDatabaseUser::class,
                DeleteDatabaseUser::class
            ]);
        }

        // Publish config
        $this->publishes([
             __DIR__ . '/../config/basic-lock.php' => base_path('config/basic-lock.php') 
        ], 'config');

        // Publish migrations
        if(! class_exists('CreateBasicAuthUsersTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_basic_lock_users_table.php.stub' => 
                database_path('migrations/' . date('Y_m_d_His', time()) . '_create_basic_lock_users_table.php')
            ], 'migrations');
        }
        
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/basic-lock.php', 'basic-lock');
        
        // Register implementations
        $this->app->bind(BasicLockFactory::class, function ($app) {
            return new BasicLockFactory($app);
        });
    }
}
