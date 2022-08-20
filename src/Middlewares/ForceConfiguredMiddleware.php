<?php

namespace Zevitagem\LegoAuth\Middlewares;

use Zevitagem\LegoAuth\Helpers\Helper;
use Illuminate\Http\Request;
use Zevitagem\LegoAuth\Exceptions\NeedBeHasConfigException;
use Throwable;

class ForceConfiguredMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            if (!Helper::hasPage('user_config')) {
                return $next($request);
            }

            $config = Helper::getUserConfig();

            if (empty($config)) {
                throw new NeedBeHasConfigException();
            }

            return $next($request);
        } catch (Throwable $th) {
            return Helper::getLoginAdapter()->redirUserConfigPage();
        }
    }
}
