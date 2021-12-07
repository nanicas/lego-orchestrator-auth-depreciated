<?php

namespace App\Libraries\Annacode\Adapters;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\Login\RawLoginAdapter;
use App\Libraries\Annacode\Adapters\Login\LaravelLoginAdapter;
use App\Libraries\Annacode\Adapters\Session\RawSessionAdapter;
use App\Libraries\Annacode\Adapters\Session\LaravelSessionAdapter;
use App\Libraries\Annacode\Adapters\Cookie\RawCookieAdapter;
use App\Libraries\Annacode\Adapters\Cookie\LaravelCookieAdapter;

class FactoryAdapter
{
    const LOGIN_TYPE   = 'Login';
    const SESSION_TYPE = 'Session';
    const COOKIE_TYPE  = 'Cookie';

    protected static $instance = array();

    public static function instance(string $type)
    {
        if (isset(static::$instance[$type])) {
            return static::$instance[$type];
        }

        if (!is_dir(__DIR__.DIRECTORY_SEPARATOR.$type)) {
            throw new \InvalidArgumentException("Adapter [{$type}] type was not found");
        }

        $config = Helper::readConfig();
        if (isset($config['is_laravel']) && $config['is_laravel'] === true) {
            return static::$instance[$type] = self::caseLaravel($type);
        }

        return static::$instance[$type] = self::caseRaw($type);
    }

    private static function caseRaw(string $type)
    {
        switch ($type) {
            case self::LOGIN_TYPE:
                return new RawLoginAdapter();
                break;
            case self::SESSION_TYPE:
                return new RawSessionAdapter();
                break;
            case self::COOKIE_TYPE:
                return new RawCookieAdapter();
        }
    }

    private static function caseLaravel(string $type)
    {
        switch ($type) {
            case self::LOGIN_TYPE:
                return new LaravelLoginAdapter();
                break;
            case self::SESSION_TYPE:
                return new LaravelSessionAdapter();
                break;
            case self::COOKIE_TYPE:
                return new LaravelCookieAdapter();
        }
    }

    protected function __clone()
    {

    }

    protected function __construct()
    {

    }
}