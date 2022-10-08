<?php

namespace Zevitagem\LegoAuth\Controllers\Api;

use Zevitagem\LegoAuth\Controllers\Api\AbstractApiController;
use Zevitagem\LegoAuth\Services\Api\UserApiService;

class UserApiController extends AbstractApiController
{
    public function __construct()
    {
        //$config = Helper::readConfig();
        
        $service = new UserApiService();

        $this->setService($service);
        
        parent::__construct();
    }
}