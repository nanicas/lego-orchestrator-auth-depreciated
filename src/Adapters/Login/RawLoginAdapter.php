<?php

namespace Zevitagem\LegoAuth\Adapters\Login;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Adapters\General\RawGeneralAdapter;

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