<?php

namespace Arbory\AdminLog;

use Arbory\AdminLog\Console\Commands\CleanupAdminLog;
use Arbory\AdminLog\Http\Middleware\LogAdminRequests;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AdminLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        if ($router->hasMiddlewareGroup('admin')) {
            $router->pushMiddlewareToGroup('admin', LogAdminRequests::class);
        }

        $this->publishes([
            __DIR__ . '/../config/admin-log.php' => config_path('admin-log.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang/' => resource_path('lang/vendor/admin-log')
        ], 'translations');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'admin-log');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CleanupAdminLog::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/admin-log.php', 'admin-log');
    }
}
