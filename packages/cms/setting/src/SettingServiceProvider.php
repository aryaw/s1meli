<?php

namespace Cms\Setting;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
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

        $this->loadViewsFrom(realpath(__DIR__.'/Views'), 'setting');

        $this->publishConfig();

        $this->registerHelpers();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {        
        $this->mergeConfig();        

        $this->app->bind('setting',function(){

            return new Setting();

        });
    }


    /**
     * Register helpers file
     */
    public function registerHelpers()
    {        
        if (file_exists($file = __DIR__ . '/Helpers/Helpers.php'))
        {
            require $file;
        }
    }

    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('app.constants.php')], 'config');
    }

    private function getConfigPath()
    {
        return __DIR__ . '/../config/app.constants.php';
    }

    private function mergeConfig()
    {
        $path = $this->getConfigPath();        
        $this->mergeConfigFrom($path, 'app.constants');
    }
}
