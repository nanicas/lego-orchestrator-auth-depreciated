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
        $service = $this->getService();

        try {
            $data     = $service->{$name}(...$arguments);
            $status   = true;
            $response = $data;
        } catch (\Throwable $ex) {
            $message  = $ex->getMessage();
            $status   = false;
            $response = ['message' => $message];
        }

        header('Content-Type: application/json');
        echo json_encode(Helper::createDefaultJsonToResponse($status, $response));
    }
}