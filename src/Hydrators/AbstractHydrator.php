<?php

namespace Zevitagem\LegoAuth\Hydrators;

abstract class AbstractHydrator
{

    abstract public function getModel(): string;

    public function newModel(array $data = [])
    {
        return new ($this->getModel())($data);
    }

    public function hydrateArray(array $data)
    {
        return self::newModel()->hydrate($data);
    }

    public function hydrate(array $data)
    {
        return self::newModel($data);
    }
}