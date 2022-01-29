<?php

namespace Zevitagem\LegoAuth\Adapters\General;

use Zevitagem\LegoAuth\Adapters\General\AbstractGeneralAdapter;

class RawGeneralAdapter extends AbstractGeneralAdapter
{

    public function loadView(string $path, array $data)
    {
        $path = str_replace('.', '/', $path);
        $path = parent::getViewPath().'/'.$path;

        $this->incrementExtensionFiles($path);

        return includeWithVariables(view($path), $data);
    }

    public function getLoginRoute()
    {
        $login = env('APP_LOGIN_ROUTE') ?? '/routes/login.php';
        return env('APP_URL').$login;
    }

    public function setFlash($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function redirect(string $path, array $params = [])
    {
        $this->incrementExtensionFiles($path);

        header("Location: ".route($path.'?'.http_build_query($params)));
    }

    private function incrementExtensionFiles(&$file, $ext = '.php')
    {
        if (strpos($file, $ext) === false) {
            $file .= $ext;
        }
    }
}