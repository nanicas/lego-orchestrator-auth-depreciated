<?php

namespace Zevitagem\LegoAuth\Middlewares;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Exceptions\ExpiredSessionException;
use Zevitagem\LegoAuth\Exceptions\NotAuthenticatedException;
use Zevitagem\LegoAuth\Services\SessionService;

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
            return $loginAdapter->redirLoginPage(['message' => $thr->getMessage() .' = [' . $thr->getFile() . '] on line ' . $thr->getLine()]);
        }
    }
}