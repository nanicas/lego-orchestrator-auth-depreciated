<?php

namespace Zevitagem\LegoAuth\Controllers\Api;

use Zevitagem\LegoAuth\Controllers\Api\AbstractApiController;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Services\Api\UserApiService;

class UserApiController extends AbstractApiController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $config = Helper::readConfig();
        
        $service = new UserApiService();

        $this->setService($service);
    }
}