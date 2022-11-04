<?php

namespace Zevitagem\LegoAuth\Adapters\Cookie;

use Illuminate\Support\Facades\Cookie;
use Zevitagem\LegoAuth\Adapters\Cookie\RawCookieAdapter;
use \Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Cookie\CookieValuePrefix;

class LaravelCookieAdapter
{

    public function configureContinuousData(array $data)
    {
        $expireTime = ($data['expire_at'] / 60); //minutes

        $key = 'current_auth';
        Cookie::queue(
            $key,
            $data['session_identifier'],
            $expireTime,
            //$data['path']
        );

        $key = "auth_refresh_token.{$data['session_identifier']}";
        Cookie::queue(
            $key,
            $data['refresh_token'],
            $expireTime,
            //$data['path']
        );
    }

    public function eraseCookieValue(array $sessionData)
    {
        if (!isset($sessionData['auth'])) {
            return;
        }

        $authKeys = array_keys($sessionData['auth']);

        Cookie::queue(Cookie::forget('current_auth'));

        foreach ($authKeys as $key) {
            Cookie::queue(Cookie::forget("auth_refresh_token.{$key}"));
        }
    }

    public function readCookieValue($key)
    {
        if (!empty($value = request()->cookie($key) ?? null)) {
            return $value;
        }

        $raw   = new RawCookieAdapter();
        if (empty($value = $raw->readCookieValue($key))) {
            return $value;
        }

        $encrypter = app(Encrypter::class);
        $decrypted = $encrypter->decrypt($value, false);

        return CookieValuePrefix::remove($decrypted);
    }

    public function changeContinuousDataByIdentifier(array $data)
    {
        Cookie::queue(
            'current_auth', $data['session_identifier'],
            $data['expire_at'],
            //$data['path']
        );
    }
}