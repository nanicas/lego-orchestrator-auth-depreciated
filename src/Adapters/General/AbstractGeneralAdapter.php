<?php

namespace Zevitagem\LegoAuth\Adapters\General;

abstract class AbstractGeneralAdapter
{
    const VIEW_PREFIX = 'anc';
    const VIEW_PATH   = 'vendor/'.self::VIEW_PREFIX;

    public static function getViewPrefix()
    {
        return self::VIEW_PREFIX;
    }

    public static function getViewPath()
    {
        return self::VIEW_PATH;
    }
}