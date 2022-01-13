<?php

namespace Zevitagem\LegoAuth\Controllers\Raw;

use Zevitagem\LegoAuth\Controllers\Raw\AbstractRawLoginController;
use Zevitagem\LegoAuth\Services\AuthenticationService;

class LogoutRawNotSourceController extends AbstractRawLoginController
{
    private array $tempSessionData = [];

    public function logout()
    {
        $this->tempSessionData = $_SESSION;

        session_destroy();

        $this->loggedOut();
    }

    private function loggedOut()
    {
        $authService = new AuthenticationService($this->tempSessionData);
        $authService->deauthenticateUser();
    }
}