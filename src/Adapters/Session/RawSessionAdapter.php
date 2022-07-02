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
            'authenticator' => $data['authenticator'],
            'requester' => $data['requester'],
            'slug' => $data['slug'],
            'user' => $data['user'],
            'segment' => $data['segment'],
            'customer' => $data['customer'],
            'contract' => $data['contract'],
            'created_at' => $data['created_at']
        ];
    }

    public function eraseSessionValue()
    {
        unset($_SESSION["current_auth"]);
        unset($_SESSION["is_logged"]);
        unset($_SESSION["auth"]);
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