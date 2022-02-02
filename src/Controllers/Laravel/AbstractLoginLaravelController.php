<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Zevitagem\LegoAuth\Controllers\Laravel\AbstractAuthLaravelController;
use Zevitagem\LegoAuth\Traits\AuthActionsTrait;
use Illuminate\Http\Request;
use Zevitagem\LegoAuth\Services\SessionService;
use Zevitagem\LegoAuth\Services\AuthenticationService;
use Zevitagem\LegoAuth\Helpers\Helper;

abstract class AbstractLoginLaravelController extends AbstractAuthLaravelController
{
    private array $tempSessionData = [];

    use AuthenticatesUsers {
        logout as public defaultLogout;
    }

    use AuthActionsTrait {
        AuthActionsTrait::authenticated insteadof AuthenticatesUsers;
    }

    public function generateTempAuthInSourcer()
    {
        Helper::defaultExecutationToReplyJson(function () {
            return $this->getAuthorizationService()->generateTempAuthInSourcer();
        });
    }

    abstract public function showLoginForm();

    public function logout(Request $request)
    {
        $this->tempSessionData = session()->all();

        return $this->defaultLogout($request);
    }

    public function loggedOut(Request $request)
    {
        $authService = new AuthenticationService($this->tempSessionData);
        $authService->deauthenticateUser();
    }
}