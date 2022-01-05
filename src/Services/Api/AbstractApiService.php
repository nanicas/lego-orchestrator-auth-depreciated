<?php

namespace Zevitagem\LegoAuth\Services\Api;

use Zevitagem\LegoAuth\Services\AbstractService;
use Zevitagem\LegoAuth\Traits\AvailabilityWithService;
use Zevitagem\LegoAuth\Services\UserService;

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