<?php

namespace Zevitagem\LegoAuth\Adapters;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Adapters\Login\RawLoginAdapter;
use Zevitagem\LegoAuth\Adapters\Login\LaravelLoginAdapter;
use Zevitagem\LegoAuth\Adapters\Session\RawSessionAdapter;
use Zevitagem\LegoAuth\Adapters\Session\LaravelSessionAdapter;
use Zevitagem\LegoAuth\Adapters\Cookie\RawCookieAdapter;
use Zevitagem\LegoAuth\Adapters\Cookie\LaravelCookieAdapter;
use Zevitagem\LegoAuth\Adapters\General\LaravelGeneralAdapter;
use Zevitagem\LegoAuth\Adapters\General\RawGeneralAdapter;

class FactoryAdapter
{
    const LOGIN_TYPE   = 'Login';
    const SESSION_TYPE = 'Session';
    const COOKIE_TYPE  = 'Cookie';
    const GENERAL_TYPE  = 'General';

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
            case self::GENERAL_TYPE:
                return new RawGeneralAdapter();
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
            case self::GENERAL_TYPE:
                return new LaravelGeneralAdapter();
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