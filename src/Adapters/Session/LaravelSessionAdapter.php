<?php

namespace Zevitagem\LegoAuth\Adapters\Session;

class LaravelSessionAdapter
{

    public function startSession()
    {
        //Laravel already it injecting web middleware in all resquests from web.php
    }

    public function configureTempSessionData(array $data)
    {
        $auths = session('auth') ?? [];
        $auths = array_merge($auths,
            [
                $data['session_identifier'] => [
                    'token' => $data['token'],
                    'expire_at' => $data['expire_at'],
                    'authenticator' => $data['authenticator'],
                    'requester' => $data['requester'],
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

    public function eraseSessionValue()
    {
        session()->forget(['current_auth', 'is_logged', 'auth']);
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