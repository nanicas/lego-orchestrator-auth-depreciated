<?php

namespace Zevitagem\LegoAuth\Middlewares;

use Zevitagem\LegoAuth\Helpers\Helper;
use Illuminate\Http\Request;
use Zevitagem\LegoAuth\Staters\AppStater;

class FillerSingletonStateMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            if (Helper::isLogged()) {
                
                $config = Helper::getUserConfig();
                
                AppStater::setItem('user_config', $config);
            }
            
        } finally {
            return $next($request);
        }
    }
}