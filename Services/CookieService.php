<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\FactoryAdapter;
use App\Libraries\Annacode\Contracts\PersistenceDataContract;
use App\Libraries\Annacode\Exceptions\CurrentAuthNotFoundException;

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
}