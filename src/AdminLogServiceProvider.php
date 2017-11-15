<?php

namespace Mungurs\AdminLog;


use App\Http\Middleware\LogAdminRequests;
use Arbory\Merchant\Controllers\Admin\AdminLogController;
use Illuminate\Support\ServiceProvider;
use Arbory\Base\Support\Facades\Admin;

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
        Admin::modules()->register(AdminLogController::class);
        $menuConfig = config('arbory.menu', null);
        if ($menuConfig === null) {
            throw new \Exception('Missing menu in arbory config');
        }
        // Append new menu item
        $menuConfig = $menuConfig[] = [AdminLogController::class];
        // Store changes back in config
        config(['arbory.menu' => $menuConfig]);
    }
}
