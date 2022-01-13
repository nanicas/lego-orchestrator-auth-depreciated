<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;
use Zevitagem\LegoAuth\Contracts\PersistenceDataContract;
use Zevitagem\LegoAuth\Exceptions\CurrentAuthNotFoundException;

class CookieService implements PersistenceDataContract
{

    public static function getAdapter()
    {
        return Helper::getAdapter(FactoryAdapter::COOKIE_TYPE);
    }

    /**
     * @return string
     * @throws CurrentAuthNotFoundException
     */
    public static function getIdentifier()
    {
        $currentKey = self::getAdapter()->readCookieValue('current_auth');

        if (empty($currentKey)) {
            throw new CurrentAuthNotFoundException('Não foi possível encontrar os dados atuais');
        }

        return $currentKey;
    }

    public static function getRefreshTokenByIdentifier(string $identifier)
    {
        return self::getAdapter()->readCookieValue("auth_refresh_token_{$identifier}");
    }

    public static function eraseAll(array $sessionData)
    {
        $adapter = self::getAdapter();
        $adapter->eraseCookieValue($sessionData);
    }
}