<?php

namespace Zevitagem\LegoAuth\Hydrators;

use Zevitagem\LegoAuth\Helpers\Helper;

abstract class AbstractHydrator
{
    public function getModel(): string
    {
        return static::staticGetModel();
    }

    public function newModel(array $data = [])
    {
        $model = $this->getModel();
	return new $model($data);
    }

    public function hydrateArray(array $data)
    {
        return static::newModel()->hydrate($data);
    }

    public function hydrate(array $data)
    {
        return static::newModel($data);
    }

    public static function staticNewModel(array $data = [])
    {
	$model = static::staticGetModel();
        return new $model($data);
    }

    public static function staticHydrate(array $data)
    {
        return static::staticNewModel($data);
    }

    public static function staticGetModel(): string
    {
        $class = get_called_class();

        return Helper::readConfig()['models'][$class::NAME];
    }
}
