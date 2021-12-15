<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Libraries\Annacode\Controllers\Laravel\AbstractAuthLaravelController;
use App\Libraries\Annacode\Traits\AuthActionsTrait;

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