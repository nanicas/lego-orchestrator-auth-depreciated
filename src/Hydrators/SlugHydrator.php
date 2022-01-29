<?php

namespace Zevitagem\LegoAuth\Hydrators;

use Zevitagem\LegoAuth\Helpers\Helper;

class SlugHydrator
{

    public function getModel()
    {
        $model = Helper::readConfig()['models']['slug'];
        return new $model();
    }

    public function hydrateArray(array $data)
    {
        return $this->getModel()->hydrate($data);
    }
}