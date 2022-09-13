<?php

namespace Zevitagem\LegoAuth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $file = base_path('routes/lego.php');

        if (file_exists($file)) {
            Route::namespace($this->namespace)
                    ->group($file);
        }
    }
}
