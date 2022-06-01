<?php

namespace Zevitagem\LegoAuth\Middlewares\Laravel;

use Zevitagem\LegoAuth\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceLoginCaseLoggedWithOutRequestMiddleware
{
    public function handle(Request $request, \Closure $next, ...$guards)
    {
        if (!Helper::isOutSourcedAccess() || !Auth::check()) {
            return $next($request);
        }

        Auth::logout();

        return redirect()->route('login', $request->query());
    }
}