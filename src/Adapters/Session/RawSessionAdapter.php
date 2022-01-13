<?php

namespace Zevitagem\LegoAuth\Adapters\Session;

class RawSessionAdapter
{

    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function configureTempSessionData(array $data)
    {
        $_SESSION['current_auth']                      = $data['session_identifier'];
        $_SESSION['is_logged']                         = $data['is_logged'];
        $_SESSION['auth'][$data['session_identifier']] = [
            'token' => $data['token'],
            'expire_at' => $data['expire_at'],
            'own_url' => $data['own_url'],
            'own_api_url' => $data['own_api_url'],
            'own_internal_api_url' => $data['own_internal_api_url'],
            'own_id' => $data['own_id'],
            'slug' => $data['slug'],
            'user' => $data['user'],
            'created_at' => $data['created_at']
        ];
    }

    public function changeTempSessionDataByIdentifier(array $data)
    {
        $_SESSION['current_auth'] = $data['session_identifier'];
    }

    public function readSessionValue($key)
    {
        return $_SESSION[$key] ?? null;
    }
}