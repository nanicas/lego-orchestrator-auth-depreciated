<?php

namespace Zevitagem\LegoAuth\Services\Login;

use Zevitagem\LegoAuth\Services\Login\AbstractLoginService;

class LoginSourceService extends AbstractLoginService
{
    public function getDataOnShowLogin(array $config)
    {
        if (empty($config)) {
            $config['with_slugs'] = '1';
        }

        return [
            'slugs' => $this->getSlugs($config)
        ];
    }
}