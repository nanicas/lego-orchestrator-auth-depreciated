<?php

namespace App\Libraries\Annacode\Adapters\Login;

class RawLoginAdapter
{

    public function view(string $path, array $data)
    {
        return includeWithVariables(view($path), $data);
    }

    public function setFlash($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function redirect(string $path, array $params = [])
    {
        if (strpos($path, '.php') === false) {
            $path .= '.php';
        }

        header("Location: ".route($path.'?'.http_build_query($params)));
    }

    public function redirSuccessfully()
    {
        header("Location: ".route('home.php'));
    }
}