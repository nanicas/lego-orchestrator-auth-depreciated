<?php

namespace Zevitagem\LegoAuth\Hydrators;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Hydrators\AbstractHydrator;

class ApplicationHydrator extends AbstractHydrator
{

    public function getModel(): string
    {
        $model = Helper::readConfig()['models']['application'];
        return new $model();
    }
}