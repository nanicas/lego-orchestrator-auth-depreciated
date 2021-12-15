<?php

namespace App\Libraries\Annacode\Services\Login;

use App\Libraries\Annacode\Services\AbstractService;

abstract class AbstractLoginService extends AbstractService
{

    public function getDataOnShowLogin()
    {
        return [];
    }
}