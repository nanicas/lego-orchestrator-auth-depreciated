<?php

namespace App\Libraries\Annacode\Middlewares;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Exceptions\ExpiredSessionException;
use App\Libraries\Annacode\Exceptions\NotAuthenticatedException;
use App\Libraries\Annacode\Services\SessionService;

class AuthFillerMiddleware
{

    public function handle($request, \Closure $next, ...$guards)
    {
        $loginAdapter = Helper::getLoginAdapter();

        try {
            if (method_exists($loginAdapter, 'beforeCheckedValidSession')) {
                $loginAdapter->beforeCheckedValidSession();
            }

            SessionService::isLogged();

            if (method_exists($loginAdapter, 'afterCheckedValidSession')) {
                $loginAdapter->afterCheckedValidSession();
            }

            return $next($request);
        } catch (ExpiredSessionException | NotAuthenticatedException $exc) {
            return $loginAdapter->redirLoginPage([
                    'message' => $exc->getMessage(),
                    'action' => 'tryRegenerateToken'
            ]);
        } catch (\Throwable $thr) {
            return $loginAdapter->redirLoginPage(['message' => $thr->getMessage()]);
        }
    }
}