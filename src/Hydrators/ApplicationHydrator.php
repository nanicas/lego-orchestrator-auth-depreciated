<?php

namespace Zevitagem\LegoAuth\Hydrators;

use Zevitagem\LegoAuth\Helpers\Helper;

class ApplicationHydrator
{

    public function getModel()
    {
        $model = Helper::readConfig()['models']['application'];
        return new $model();
    }

    public function hydrateArray(array $data)
    {
        return $this->getModel()->hydrate($data);
    }
}