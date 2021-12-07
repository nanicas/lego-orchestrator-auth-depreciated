<?php

namespace App\Libraries\Annacode\Traits;

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