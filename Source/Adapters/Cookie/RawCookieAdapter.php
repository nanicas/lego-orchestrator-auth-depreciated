<?php

namespace App\Libraries\Annacode\Adapters\Cookie;

class RawCookieAdapter
{

    public function configureCookie(array $data)
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

    public function readCookieValue($key)
    {
        return $_COOKIE[$key] ?? null;
    }

    public function changeCookieByIdentifier(array $data)
    {
        setcookie("current_auth", $data['session_identifier'], $data['expire_at'], $data['path']);
    }
}