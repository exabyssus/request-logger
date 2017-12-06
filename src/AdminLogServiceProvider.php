<?php

namespace Mungurs\AdminLog;

use Mungurs\AdminLog\Middleware\LogAdminRequests;
use Illuminate\Support\ServiceProvider;

class AdminLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if ($router->hasMiddlewareGroup('admin')) {
            $router->pushMiddlewareToGroup('admin', LogAdminRequests::class);
        }

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->publishes([
            __DIR__ . '/Config/admin-log.php' => config_path('admin-log.php')
        ]);
        $this->mergeConfigFrom(__DIR__ . '/Config/admin-log.php', 'admin-log');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
