<?php

namespace Cms\Pengadaan;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;

class PengadaanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */    
    public function boot()
    {        
        $this->loadMigrationsFrom(realpath(__DIR__.'/Migrations'));

        $this->loadRoutesFrom(realpath(__DIR__ . "/Routes/web.php"));

        $this->loadViewsFrom(realpath(__DIR__.'/Views'), 'pengadaan');

        View::composer(
            'cms.partials.sidebar', 'Cms\Pengadaan\Http\ViewComposers\MenuComposer'
        );
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
