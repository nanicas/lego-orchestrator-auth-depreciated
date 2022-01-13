<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Exceptions\ExpiredSessionException;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Exceptions\NotAuthenticatedException;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;
use Zevitagem\LegoAuth\Contracts\PersistenceDataContract;

class SessionService implements PersistenceDataContract
{
    const ATTEMPT_MAX = 3;

    public static function getAdapter()
    {
        return Helper::getAdapter(FactoryAdapter::SESSION_TYPE);
    }

    public static function listLoggedUsers()
    {
        if (!self::isLogged()) {
            return [];
        }

        $list = [];
        foreach (self::getAdapter()->readSessionValue('auth') as $key => $session) {
            $list[] = [
                'identifier' => $key,
                'name' => $session['user']['name'],
                'own_url' => $session['own_url'],
                //'own_id' => $session['user']['own_id']
            ];
        }

        return $list;
    }

    public static function existsLoginAttempts()
    {
        return isset($_SESSION['tries']);
    }

    public static function resetLoginAttempts()
    {
        if (self::existsLoginAttempts()) {
            unset($_SESSION['tries']);
        }
    }

    public static function incrementLoginAttempt()
    {
        if (self::existsLoginAttempts()) {
            return $_SESSION['tries']++;
        }
    }

    public static function reachedMaxLoginAttempt(int $attempt)
    {
        return ($attempt > self::ATTEMPT_MAX);
    }

    public static function getCurrentAttempt()
    {
        if (!self::existsLoginAttempts()) {
            $_SESSION['tries'] = 1;
        }

        return $_SESSION['tries'];
    }

    public static function validateExpiredSession(string $identifier)
    {
        $remaing = self::getRemaingTimeToExpireByIdentifier($identifier);

        if ($remaing === false || $remaing <= 0) {
            throw new ExpiredSessionException();
        }

        return true;
    }

    public static function isLogged()
    {
        $isLogged = self::getAdapter()->readSessionValue('is_logged');

        $hasSession = ($isLogged === true);
        $identifier = self::getIdentifier();

        if (!$hasSession || empty($identifier)) {
            throw new NotAuthenticatedException();
        }

        self::validateExpiredSession($identifier);

        return true;
    }

    public static function getIdentifier()
    {
        return self::getAdapter()->readSessionValue('current_auth');
    }

    public static function isLoggedByIdentifier(string $key)
    {
        self::isLogged();

        $auth = self::getAdapter()->readSessionValue('auth');

        if (empty($auth)) {
            throw new NotAuthenticatedException();
        }

        if (!isset($auth[$key])) {
            throw new NotAuthenticatedException();
        }

        return true;
    }

    public static function getRemaingTimeToExpireByIdentifier(string $id)
    {
        if (empty($auth = self::getAdapter()->readSessionValue('auth'))) {
            return false;
        }

        return $auth[$id]['expire_at'] - (time() - $auth[$id]['created_at']);
    }

    public static function eraseAll(array $sessionData)
    {
        $adapter = self::getAdapter();
        $adapter->eraseSessionValue();
    }

    public static function getCurrentData()
    {
        if (!self::isLogged()) {
            return;
        }

        if (empty($auth = self::getAdapter()->readSessionValue('auth'))) {
            return;
        }

        $identifier = self::getIdentifier();

        return $auth[$identifier];
    }

    public static function getUserSession()
    {
        $auth = self::getCurrentData();

        return (empty($auth)) ? null : $auth['user'];
    }
}