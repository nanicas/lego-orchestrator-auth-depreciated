<?php

namespace Zevitagem\LegoAuth\Traits;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;

trait NotSourcedAuthActionsTrait
{
    public function showLoginForm()
    {  //dd(session()->all());
        if (Helper::existsTempAuthInUrl()) {
            return $this->generateTokenByTemp();
        }

        $data    = $this->getService()->getDataOnShowLogin();
        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);

        return $adapter->loadView('outsourced_login', $data);
    }
}