<?php

namespace App\Libraries\Annacode\Services\Api;

use App\Libraries\Annacode\Services\AbstractService;
use App\Libraries\Annacode\Traits\AvailabilityWithService;
use App\Libraries\Annacode\Services\UserService;

abstract class AbstractApiService extends AbstractService
{

    use AvailabilityWithService;

    public function __construct()
    {
        $service = new UserService();
        $this->setService($service);
    }

    public function __call($name, $arguments)
    {
        return $this->getService()->{$name}(...$arguments);
    }
}