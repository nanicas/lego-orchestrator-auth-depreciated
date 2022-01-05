<?php

namespace Zevitagem\LegoAuth\Traits;

use Zevitagem\LegoAuth\Services\AbstractService;

trait AvailabilityWithService
{
    private $service;

    public function setService(AbstractService $service)
    {
        $this->service = $service;
    }

    public function getService()
    {
        return $this->service;
    }
}