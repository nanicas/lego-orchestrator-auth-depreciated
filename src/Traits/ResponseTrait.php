<?php

namespace Zevitagem\LegoAuth\Traits;

trait ResponseTrait
{
    private $response;

    protected function setResponse($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}