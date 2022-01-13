<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Factories\PersistenceDataFactory;

class AuthenticationService
{
    private array $sessionData;

    public function __construct(array $sessionData = [])
    {
        $this->sessionData = $sessionData;
    }

    private function getSessionData()
    {
        return $this->sessionData;
    }

    public function deauthenticateUser()
    {
        $temp       = PersistenceDataFactory::temp();
        $continuous = PersistenceDataFactory::continuous();

        $sessionData = $this->getSessionData();

        $temp->eraseAll($sessionData);
        $continuous->eraseAll($sessionData);
    }
}