<?php

namespace Zevitagem\LegoAuth\Services\Api;

use Zevitagem\LegoAuth\Contracts\ApiResourceFactoryContract;
use Zevitagem\LegoAuth\Services\UserService;
use Zevitagem\LegoAuth\Services\Api\AbstractApiService;

class UserApiService extends AbstractApiService implements ApiResourceFactoryContract
{

    public function __construct()
    {
        $service = new UserService();
        $this->setService($service);
    }
}