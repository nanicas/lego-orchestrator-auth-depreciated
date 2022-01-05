<?php

namespace Zevitagem\LegoAuth\Models\Raw;

use Zevitagem\LegoAuth\Models\AbstractRawModel;
use Zevitagem\LegoAuth\Traits\Models\ApplicationModelTrait;

class ApplicationR extends AbstractRawModel
{

    use ApplicationModelTrait;

    const TABLE = 'applications';
}