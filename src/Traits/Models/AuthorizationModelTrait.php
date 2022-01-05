<?php

namespace Zevitagem\LegoAuth\Traits\Models;

trait AuthorizationModelTrait
{

    public function getCode()
    {
        return $this->code;
    }
}