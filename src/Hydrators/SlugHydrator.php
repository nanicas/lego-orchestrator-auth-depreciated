<?php

namespace Zevitagem\LegoAuth\Hydrators;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Hydrators\AbstractHydrator;

class SlugHydrator extends AbstractHydrator
{

    public function getModel(): string
    {
        return Helper::readConfig()['models']['slug'];
    }
}