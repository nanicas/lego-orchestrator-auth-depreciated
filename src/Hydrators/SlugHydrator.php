<?php

namespace Zevitagem\LegoAuth\Hydrators;

use Zevitagem\LegoAuth\Helpers\Helper;

class SlugHydrator
{

    public function getModel()
    {
        return Helper::readConfig()['models']['slug'];
    }

    public function hydrateArray(array $data)
    {
        return (new $this->getModel())->hydrate($data);
    }

    public function hydrate(array $data)
    {
        return new (self::getModel())($data);
    }
}