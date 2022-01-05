<?php

namespace Zevitagem\LegoAuth\Services\Login;

use Zevitagem\LegoAuth\Services\AbstractService;

abstract class AbstractLoginService extends AbstractService
{

    public function getDataOnShowLogin()
    {
        return [];
    }
}