<?php

namespace Zevitagem\LegoAuth\Models;

use Zevitagem\LegoAuth\Traits\Models\ApplicationModelTrait;

abstract class AbstractRawModel
{
    use ApplicationModelTrait;
    
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attr => $value) {
            $this->{$attr} = $value;
        }

        return $this;
    }

    public static function hydrate(array $data)
    {
        return array_map(function ($entity) {
            return new static($entity);
        }, $data);
    }

    public function getTable()
    {
        return static::TABLE;
    }
}