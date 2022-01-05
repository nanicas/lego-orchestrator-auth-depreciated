<?php

namespace Zevitagem\LegoAuth\Factories;

use Zevitagem\LegoAuth\Services\SessionService;
use Zevitagem\LegoAuth\Services\CookieService;

class PersistenceDataFactory
{
    private static $temp;
    private static $continuous;

    public static function temp()
    {
        if (empty(self::$temp)) {
            self::$temp = new SessionService();
        }

        return self::$temp;
    }

    public static function continuous()
    {
        if (empty(self::$continuous)) {
            self::$continuous = new CookieService();
        }

        return self::$continuous;
    }
}