<?php

namespace App\Libraries\Annacode\Models\Raw;

use App\Libraries\Annacode\Models\AbstractRawModel;
use App\Libraries\Annacode\Traits\Models\AuthorizationModelTrait;

class AuthorizationR extends AbstractRawModel
{

    use AuthorizationModelTrait;

    const TABLE = 'authorizations';
}