<?php

namespace Zevitagem\LegoAuth\Controllers\Api;

use Zevitagem\LegoAuth\Controllers\Api\AbstractApiController;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Services\Api\ConfigUserApiService;

class ConfigUserApiController extends AbstractApiController
{

    public function __construct()
    {
        //$config = Helper::readConfig();

        $service = new ConfigUserApiService();

        $this->setService($service);
    }
}