<?php

namespace Cms\Dashboard;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */    
    public function boot()
    {        
        #$this->loadMigrationsFrom(realpath(__DIR__.'/Migrations'));

        $this->loadRoutesFrom(realpath(__DIR__ . "/Routes/web.php"));

        $this->loadViewsFrom(realpath(__DIR__.'/Views'), 'dashboard');
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
