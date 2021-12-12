<?php

namespace App\Libraries\Annacode\Adapters\Login;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\General\RawGeneralAdapter;

class RawLoginAdapter
{

    public function redirSuccessfully()
    {
        header("Location: ".route('home.php'));
    }

    public function redirLoginPage(array $params = [])
    {
        $adapter = new RawGeneralAdapter();
        return $adapter->redirect('login', $params);
    }

    public function beforeCheckedValidSession()
    {
        Helper::sessionStart();
    }
}