<?php

namespace App\Libraries\Annacode\Adapters\General;

class LaravelGeneralAdapter
{
    const VIEW_PREFIX = 'annacode';

    public function loadView(string $path, array $data = [])
    {
        if (strpos($path, self::VIEW_PREFIX) === false) {
            $path = self::VIEW_PREFIX.'::'.$path;
        }

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
}