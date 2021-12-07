<?php

namespace App\Libraries\Annacode\Controllers\Api;

use App\Libraries\Annacode\Controllers\Api\AbstractApiController;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Services\Api\UserApiService;

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