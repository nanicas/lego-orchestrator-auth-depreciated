<?php

namespace Zevitagem\LegoAuth\Models\Raw;

use Zevitagem\LegoAuth\Models\AbstractRawModel;
use Zevitagem\LegoAuth\Traits\Models\AuthorizationModelTrait;

class AuthorizationR extends AbstractRawModel
{

    use AuthorizationModelTrait;

    const TABLE = 'authorizations';
}