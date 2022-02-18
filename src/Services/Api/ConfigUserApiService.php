<?php

namespace Zevitagem\LegoAuth\Services\Api;

use Zevitagem\LegoAuth\Contracts\ApiResourceFactoryContract;
use Zevitagem\LegoAuth\Services\ConfigUserService;
use Zevitagem\LegoAuth\Services\Api\AbstractApiService;

class ConfigUserApiService extends AbstractApiService implements ApiResourceFactoryContract
{

    public function __construct()
    {
        $service = new ConfigUserService();
        $this->setService($service);
    }
}