<?php

namespace App\Libraries\Annacode\Adapters\Login;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Libraries\Annacode\Services\SessionService;
use App\Libraries\Annacode\Adapters\General\LaravelGeneralAdapter;

class LaravelLoginAdapter
{

    public function redirSuccessfully()
    {
        return redirect()->route(str_replace('/', '', RouteServiceProvider::HOME));
    }

    public function afterCheckedValidSession()
    {
        $user = new User(SessionService::getUserSession());

        Auth::setUser($user);
    }

    public function redirLoginPage(array $params = [])
    {
        $adapter = new LaravelGeneralAdapter();
        return $adapter->redirect('login', $params);
    }
}