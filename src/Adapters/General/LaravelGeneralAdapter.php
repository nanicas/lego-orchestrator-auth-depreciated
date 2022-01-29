<?php

namespace Zevitagem\LegoAuth\Adapters\General;

use Zevitagem\LegoAuth\Adapters\General\AbstractGeneralAdapter;

class LaravelGeneralAdapter extends AbstractGeneralAdapter
{

    public function loadView(string $path, array $data = [])
    {
        $path   = str_replace('/', '.', $path);
        $prefix = parent::getViewPrefix();

        if (strpos($path, $prefix) === false) {
            $path = $prefix.'::'.$path;
        }
        //dd($path);
        //$path = 'anc::outsourced_login.blade';

        return view($path, $data);
    }

    public function getLoginRoute()
    {
        if (!empty($login = env('APP_LOGIN_ROUTE'))) {
            return env('APP_URL') . $login;
        }

        return route('login');
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
}