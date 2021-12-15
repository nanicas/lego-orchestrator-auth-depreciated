<?php

namespace App\Libraries\Annacode\Adapters\General;

use App\Libraries\Annacode\Adapters\General\AbstractGeneralAdapter;

class RawGeneralAdapter extends AbstractGeneralAdapter
{

    public function loadView(string $path, array $data)
    {
        $this->incrementExtensionFiles($path);

        $path = parent::getViewPath().'/'.$path;

        return includeWithVariables(view($path), $data);
    }

    public function getLoginRoute()
    {
        $login = env('APP_LOGIN_ROUTE') ?? '/routes/login.php';
        return env('APP_URL') . $login;
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