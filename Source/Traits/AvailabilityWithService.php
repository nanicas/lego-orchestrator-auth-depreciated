<?php

namespace App\Libraries\Annacode\Traits;

use App\Libraries\Annacode\Services\AbstractService;

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