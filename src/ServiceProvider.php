<?php

namespace Gwleuverink\Lockdown;

use Gwleuverink\Lockdown\Lockdown;
use Gwleuverink\Lockdown\LockdownFactory;
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateDatabaseUser::class,
                DeleteDatabaseUser::class
            ]);
        }

        // Publish config
        $this->publishes([
             __DIR__ . '/../config/lockdown.php' => base_path('config/lockdown.php')
        ], 'lockdown:config');

        // Publish migrations
        if (! class_exists('CreateBasicAuthUsersTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_basic_lock_users_table.php.stub' =>
                database_path('migrations/' . date('Y_m_d_His', time()) . '_create_basic_lock_users_table.php')
            ], 'lockdown:migrations');
        }
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/lockdown.php', 'lockdown');
        
        // Register implementations
        $this->app->bind(LockdownFactory::class, function ($app) {
            return new LockdownFactory($app);
        });
    }
}
