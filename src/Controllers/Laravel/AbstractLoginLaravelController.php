<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Zevitagem\LegoAuth\Controllers\Laravel\AbstractAuthLaravelController;
use Zevitagem\LegoAuth\Traits\AuthActionsTrait;

abstract class AbstractLoginLaravelController extends AbstractAuthLaravelController
{

    use AuthenticatesUsers,
        AuthActionsTrait {
        AuthActionsTrait::authenticated insteadof AuthenticatesUsers;
    }

    public function generateTempAuthInSourcer()
    {
        $data = $this->authorizationService->generateTempAuthInSourcer();

        echo json_encode($data);
    }

    abstract public function showLoginForm();
}