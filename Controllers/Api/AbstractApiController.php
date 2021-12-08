<?php

namespace App\Libraries\Annacode\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Traits\AvailabilityWithService;
use App\Libraries\Annacode\Contracts\ApiResourceFactoryContract;

class AbstractApiController extends Controller
{

    use AvailabilityWithService;

    public function setService(ApiResourceFactoryContract $service)
    {
        $this->service = $service;
    }

    public function __call($name, $arguments)
    {
        Helper::defaultExecutationToReplyJson(function () use ($name, $arguments) {
            $service = $this->getService();
            return $service->{$name}(...$arguments);
        });
    }
}