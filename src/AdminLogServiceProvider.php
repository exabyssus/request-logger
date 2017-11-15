<?php

namespace Mungurs\AdminLog;

use Mungurs\AdminLog\Middleware\LogAdminRequests;
use Mungurs\AdminLog\Controllers\Admin\AdminLogController;
use Illuminate\Support\ServiceProvider;
use \Arbory\Base\Support\Facades\Admin;

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
            __DIR__ . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'admin-log.php' => config_path('admin-log.php')
        ]);
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
