<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use App\Libraries\Annacode\Controllers\Laravel\AbstractAuthLaravelController;
use App\Libraries\Annacode\Adapters\FactoryAdapter;
use App\Libraries\Annacode\Traits\AuthActionsTrait;
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