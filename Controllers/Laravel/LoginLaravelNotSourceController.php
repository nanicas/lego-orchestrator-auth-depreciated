<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use App\Libraries\Annacode\Controllers\Laravel\AbstractLoginLaravelController;
use App\Libraries\Annacode\Services\Login\LoginNotSourceService;
use App\Libraries\Annacode\Traits\NavigateAsAppController;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\FactoryAdapter;

class LoginLaravelNotSourceController extends AbstractLoginLaravelController
{

    use NavigateAsAppController;

    public function __construct()
    {
        parent::__construct();

        $this->setService(new LoginNotSourceService());
    }

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