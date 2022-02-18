<?php

namespace Zevitagem\LegoAuth\Services\Api;

use Zevitagem\LegoAuth\Services\AbstractService;
use Zevitagem\LegoAuth\Traits\AvailabilityWithService;

abstract class AbstractApiService extends AbstractService
{

    use AvailabilityWithService;

    public function __call($name, $arguments)
    {
        return $this->getService()->{$name}(...$arguments);
    }
}