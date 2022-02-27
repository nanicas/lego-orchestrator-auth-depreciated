<?php

namespace Zevitagem\LegoAuth\Services\Login;

use Zevitagem\LegoAuth\Services\Login\AbstractLoginService;

class LoginSourceService extends AbstractLoginService
{

    public function getDataOnShowLogin(array $config)
    {
        return [
            'slugs' => $this->getSlugs($config)
        ];
    }
}