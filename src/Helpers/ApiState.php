<?php

namespace Zevitagem\LegoAuth\Helpers;

class ApiState
{
    protected static $instance = null;
    protected static $config   = array();

    /** call this method to get instance */
    public static function instance(array $config)
    {
        if (static::$instance === null) {
            static::$instance = new static();
            static::$instance->setConfig($config);
        }

        return static::$instance;
    }

    /** protected to prevent cloning */
    protected function __clone()
    {

    }

    private static function setConfig(array $config)
    {
        self::$config = $config;
    }

    public static function all()
    {
        return self::$config;
    }

    public static function getConfig(string $key)
    {
        return self::$config[$key] ?? null;
    }

    /** protected to prevent instantiation from outside of the class */
    protected function __construct()
    {

    }
}