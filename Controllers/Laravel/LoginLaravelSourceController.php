<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use App\Libraries\Annacode\Services\Login\LoginSourceService;
use App\Libraries\Annacode\Controllers\Laravel\AbstractLoginLaravelController;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\FactoryAdapter;
use App\Libraries\Annacode\Helpers\ApiState;

class LoginLaravelSourceController extends AbstractLoginLaravelController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth.reuse')->only('showLoginForm');
        $this->middleware('guest')->except('logout');
        
        $this->setService(new LoginSourceService());
    }

    public function showLoginForm()
    {
        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);
        return $adapter->loadView('sourced_login');
    }

    public function generateTempAuthByToken()
    {
        Helper::defaultExecutationToReplyJson(function () {
            return $this->authorizationService->getTempAuthByState(ApiState::all());
        });
    }
}