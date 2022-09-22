<?php

namespace Administration;

use Administration\Models\Menu;
use Administration\Models\Permission;
use Administration\Models\Role;
use Administration\Models\User;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

class AdministrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register our controller
        $this->app->make('Administration\Controllers\DocumentationController');
        $this->app->bind('Administration', function ($app) {
            return new Administration;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/web.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'Administration');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->publishes([
            __DIR__ . '/Assets/js' => public_path('js'),
            __DIR__ . '/Assets/css' => public_path('css'),
            __DIR__ . '/Assets/images' => public_path('images'),
            __DIR__ . '/Assets/fonts' => public_path('fonts'),
            __DIR__ . '/Assets/plugins' => public_path('plugins'),
            __DIR__ . '/Database/seeds' => database_path('seeds'),
        ], 'public');
    }
}
