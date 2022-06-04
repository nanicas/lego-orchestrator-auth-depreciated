<?php

namespace Zevitagem\LegoAuth\Traits;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;

trait NotSourcedAuthActionsTrait
{

    public function showLoginForm()
    {
        if (Helper::existsTempAuthInUrl()) {
            return $this->generateTokenByTemp();
        }

        $data    = $this->getService()->getDataOnShowLogin();
        $data['message'] = $_GET['message'] ?? '';

        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);

        $config = Helper::readConfig();
        $view   = 'outsourced_login.with_slugs_inside';

        if (!Helper::isLaravel() || $config['slugs_inside'] === false) {
            $view = 'outsourced_login.with_slugs_outside';
        }

        return $adapter->loadView($view, $data);
    }
}