<?php

namespace Zevitagem\LegoAuth\Adapters\Cookie;

class RawCookieAdapter
{

    public function configureContinuousData(array $data)
    {
        $expireTime = (time() + $data['expire_at']);

        setcookie(
            "current_auth",
            $data['session_identifier'],
            $expireTime,
            $data['path']
        ); //seconds

        setcookie(
            "auth_refresh_token.{$data['session_identifier']}",
            $data['refresh_token'],
            $expireTime,
            $data['path']
        );
    }

    public function eraseCookieValue(array $sessionData)
    {
        unset($_COOKIE['current_auth']);
        setcookie('current_auth', '', time() - 3600);

        $authKeys = array_keys($sessionData['auth']);

        foreach ($authKeys as $key) {
            $tempKey = "auth_refresh_token.{$key}";

            unset($_COOKIE[$tempKey]);
            setcookie($tempKey, '', time() - 3600);
        }
    }

    public function readCookieValue($key)
    {
        return $_COOKIE[$key] ?? null;
    }

    public function changeContinuousDataByIdentifier(array $data)
    {
        setcookie("current_auth",
            $data['session_identifier'],
            $data['expire_at'],
            $data['path']
        );
    }
}