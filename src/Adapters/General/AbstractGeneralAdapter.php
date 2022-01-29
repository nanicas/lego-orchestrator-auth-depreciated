<?php

namespace Zevitagem\LegoAuth\Adapters\General;

use Zevitagem\LegoAuth\Helpers\Helper;

abstract class AbstractGeneralAdapter
{

    public static function getPrefix()
    {
        return Helper::getPackage();
    }

    public static function getViewPrefix()
    {
        return self::getPrefix();
    }

    public static function getViewPath()
    {
        return 'vendor/'.self::getViewPrefix();
    }

    public static function getAssetsPath()
    {
        return 'vendor/'.self::getViewPrefix();
    }
}