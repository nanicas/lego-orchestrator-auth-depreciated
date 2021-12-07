<?php

namespace App\Libraries\Annacode\Services\Api;

use App\Libraries\Annacode\Contracts\ApiResourceFactoryContract;
use App\Libraries\Annacode\Services\UserService;
use App\Libraries\Annacode\Services\Api\AbstractApiService;

class UserApiService extends AbstractApiService implements ApiResourceFactoryContract
{

    public function __construct()
    {
        $service = new UserService();
        $this->setService($service);
    }
}