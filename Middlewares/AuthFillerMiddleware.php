<?php

namespace App\Libraries\Annacode\Middlewares;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Exceptions\ExpiredSessionException;
use App\Libraries\Annacode\Exceptions\NotAuthenticatedException;
use App\Libraries\Annacode\Adapters\FactoryAdapter;
use App\Libraries\Annacode\Services\SessionService;

class AuthFillerMiddleware
{

    public function handle($request, \Closure $next, ...$guards)
    {
        $adapter = Helper::getAdapter(FactoryAdapter::LOGIN_TYPE);
        
        try {
            //Helper::sessionStart();

            SessionService::isLogged();

            if (method_exists($adapter, 'afterCheckedValidSession')) {
                $adapter->afterCheckedValidSession();
            }

            return $next($request);
        } catch (ExpiredSessionException | NotAuthenticatedException $exc) {
            return $adapter->redirect(
                    'login',
                    ['message' => $exc->getMessage(), 'action' => 'tryRegenerateToken']
            );
        } catch (\Throwable $thr) {
            return $adapter->redirect('login', ['message' => $thr->getMessage()]);
        }
    }
}