<?php

namespace App\Libraries\Annacode\Factories;

use App\Libraries\Annacode\Services\SessionService;
use App\Libraries\Annacode\Services\CookieService;

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