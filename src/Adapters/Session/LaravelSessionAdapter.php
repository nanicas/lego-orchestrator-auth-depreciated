<?php

namespace Zevitagem\LegoAuth\Adapters\Session;

class LaravelSessionAdapter
{

    public function configureTempSessionData(array $data)
    {
        $auths = session('auth') ?? [];
        $auths = array_merge($auths,
            [
                $data['session_identifier'] => [
                    'token' => $data['token'],
                    'expire_at' => $data['expire_at'],
                    'own_url' => $data['own_url'],
                    'own_api_url' => $data['own_api_url'],
                    'own_id' => $data['own_id'],
                    'slug' => $data['slug'],
                    'user' => $data['user'],
                    'created_at' => $data['created_at']
                ]
            ]
        );

        session()->put([
            'current_auth' => $data['session_identifier'],
            'is_logged' => $data['is_logged'],
            'auth' => $auths
        ]);
    }

    public function readSessionValue($key)
    {
        return session()->get($key, null);
    }

    public function changeTempSessionDataByIdentifier(array $data)
    {
        session()->put('current_auth', $data['session_identifier']);
    }
}