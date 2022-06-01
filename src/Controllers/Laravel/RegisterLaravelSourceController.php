<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use Zevitagem\LegoAuth\Controllers\Laravel\AbstractAuthLaravelController;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;
use Zevitagem\LegoAuth\Traits\AuthActionsTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterLaravelSourceController extends AbstractAuthLaravelController
{

    use RegistersUsers,
        AuthActionsTrait {
        AuthActionsTrait::registered insteadof RegistersUsers;
    }

    public function showRegistrationForm(Request $request)
    {
        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);

        return $adapter->loadView('sourced_register', [
            'slug' => ($request->has('slug')) ? $request->query('slug') : 0
        ]);
    }
}