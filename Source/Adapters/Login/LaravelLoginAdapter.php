<?php

namespace App\Libraries\Annacode\Adapters\Login;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Libraries\Annacode\Services\SessionService;

class LaravelLoginAdapter
{

    public function loadView(string $path, array $data)
    {
        return view($path, $data);
    }

    public function setFlash($key, $value)
    {
        session()->flash($key, $value);
    }

    public function redirect(string $route, array $params = [])
    {
        if (isset($params['action']) && $params['action'] != 'index') {
            $route = $params['action'];
        }
        
        return redirect()->route($route, $params);
    }

    public function redirSuccessfully()
    {
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function afterCheckedValidSession()
    {
        $user = new User(SessionService::getUserSession());
        
        Auth::setUser($user);
    }
}