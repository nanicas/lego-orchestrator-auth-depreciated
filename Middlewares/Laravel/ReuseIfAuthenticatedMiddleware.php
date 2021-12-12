<?php

namespace App\Libraries\Annacode\Middlewares\Laravel;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Services\LoginSourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

        $service = new LoginSourceService();
        $user    = Auth::user();

        $authenticatedData = $service->getTempAuth(
            $user, 1//$_POST['slug']
        );

        return Redirect::to($_GET['url_callback'].'?'.$authenticatedData['params']);
    }
}