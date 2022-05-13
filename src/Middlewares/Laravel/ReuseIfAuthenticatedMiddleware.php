<?php

namespace Zevitagem\LegoAuth\Middlewares\Laravel;

use Zevitagem\LegoAuth\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Zevitagem\LegoAuth\Services\AuthorizationService;

class ReuseIfAuthenticatedMiddleware
{

    public function handle(Request $request, \Closure $next, ...$guards)
    {
        if (!Helper::isOutSourcedAccess()) {
            return $next($request);
        }

        if (!Auth::check()) {
            return $next($request);
        }

        $service = new AuthorizationService();
        $user    = Auth::user();

        $authenticatedData = $service->getTempAuth(
            $user, 1, $_GET['app_requester_id']
        );

        return Redirect::to($_GET['url_callback'].'?'.$authenticatedData['params']);
    }
}