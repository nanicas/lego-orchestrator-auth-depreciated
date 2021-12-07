<?php

namespace App\Libraries\Annacode\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            app_path('/Libraries/Annacode/Migrations') => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            app_path('/Libraries/Annacode/Routes') => base_path('routes'),
        ], 'routes');
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
