<?php

namespace Zevitagem\LegoAuth\Models\Raw;

use Zevitagem\LegoAuth\Models\AbstractRawModel;
use Zevitagem\LegoAuth\Traits\Models\SlugModelTrait;

class SlugR extends AbstractRawModel
{

    use SlugModelTrait;

    const TABLE = 'slugs';
}