<?php

namespace Zevitagem\LegoAuth\Traits\Models;

trait AbstractModelTrait
{
    public static function getPrimaryKey()
    {
        return static::PRIMARY_KEY;
    }

    public function getPrimaryValue()
    {
        return $this->{self::getPrimaryKey()};
    }

    public function getId()
    {
        return $this->getPrimaryValue();
    }
}