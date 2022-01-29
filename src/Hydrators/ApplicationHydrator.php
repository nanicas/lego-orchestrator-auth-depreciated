<?php

namespace Zevitagem\LegoAuth\Hydrators;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Hydrators\AbstractHydrator;

class ApplicationHydrator extends AbstractHydrator
{

    public function getModel(): string
    {
        return Helper::readConfig()['models']['application'];
    }
}