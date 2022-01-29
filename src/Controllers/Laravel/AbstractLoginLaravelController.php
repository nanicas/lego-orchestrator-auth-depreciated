<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Zevitagem\LegoAuth\Controllers\Laravel\AbstractAuthLaravelController;
use Zevitagem\LegoAuth\Traits\AuthActionsTrait;
use Illuminate\Http\Request;
use Zevitagem\LegoAuth\Services\SessionService;
use Zevitagem\LegoAuth\Services\AuthenticationService;

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
        $data = $this->getAuthorizationService()->generateTempAuthInSourcer();

        echo json_encode($data);
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