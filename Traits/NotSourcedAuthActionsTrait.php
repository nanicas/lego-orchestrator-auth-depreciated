<?php

namespace App\Libraries\Annacode\Traits;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\FactoryAdapter;

trait NotSourcedAuthActionsTrait
{
    public function showLoginForm()
    {
        if (Helper::existsTempAuthInUrl()) {
            return $this->generateTokenByTemp();
        }

        $data    = $this->getService()->getDataOnShowLogin();
        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);

        return $adapter->loadView('outsourced_login', $data);
    }
}