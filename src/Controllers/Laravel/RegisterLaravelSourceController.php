<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use Zevitagem\LegoAuth\Controllers\Laravel\AbstractAuthLaravelController;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;
use Zevitagem\LegoAuth\Traits\AuthActionsTrait;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterLaravelSourceController extends AbstractAuthLaravelController
{

    use RegistersUsers,
        AuthActionsTrait {
        AuthActionsTrait::registered insteadof RegistersUsers;
    }

    public function showRegistrationForm()
    {
        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);
        return $adapter->loadView('sourced_register');
    }
}