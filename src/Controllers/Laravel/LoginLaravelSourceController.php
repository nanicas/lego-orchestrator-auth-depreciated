<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use Zevitagem\LegoAuth\Services\Login\LoginSourceService;
use Zevitagem\LegoAuth\Controllers\Laravel\AbstractLoginLaravelController;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;
use Zevitagem\LegoAuth\Helpers\ApiState;
use Illuminate\Http\Request;

class LoginLaravelSourceController extends AbstractLoginLaravelController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth.reuse')->only('showLoginForm');
        $this->middleware('guest')->except('logout');
        
        $this->setService(new LoginSourceService());
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'slug' => 'required|integer'
        ]);
    }

    public function showLoginForm()
    {
        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);

        return $adapter->loadView('sourced_login', $this->getService()->getDataOnShowLogin($_GET));
    }

    public function generateTempAuthByToken()
    {
        Helper::defaultExecutationToReplyJson(function () {
            return $this->getAuthorizationService()->getTempAuthByState(ApiState::all());
        });
    }
}