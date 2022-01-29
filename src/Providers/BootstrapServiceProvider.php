<?php

namespace Zevitagem\LegoAuth\Providers;

use Illuminate\Support\ServiceProvider;
use Zevitagem\LegoAuth\Helpers\Helper;

class BootstrapServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $package = Helper::getPackage();
        $src     = base_path('vendor/zevitagem/lego-auth/src');

        $this->publishes([
            $src.'/Migrations' => database_path('migrations'),
            ], 'migrations');

        $this->publishes([
            $src.'/Routes' => base_path('routes'),
            ], 'routes');

        $this->publishes([
            $src.'/Views/Laravel' => resource_path('views/vendor/'.$package),
            ], 'views');

        $this->publishes([
            $src.'/Assets' => public_path('vendor/'.$package),
            ], 'assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}