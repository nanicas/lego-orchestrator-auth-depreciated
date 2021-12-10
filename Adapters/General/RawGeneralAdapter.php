<?php

namespace App\Libraries\Annacode\Adapters\General;

class RawGeneralAdapter
{

    public function loadView(string $path, array $data)
    {
        $this->incrementExtensionFiles($path);

        return includeWithVariables(view($path), $data);
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