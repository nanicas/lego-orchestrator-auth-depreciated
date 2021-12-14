<?php

namespace App\Libraries\Annacode\Traits;

use App\Libraries\Annacode\Services\ApplicationService;
use App\Libraries\Annacode\Adapters\FactoryAdapter;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Filters\ApplicationRemoverItself;

trait CommonActionsInLoginControllerTrait
{

    public function generateTempAuthInSourcer()
    {
        $data = $this->service->generateTempAuthInSourcer();

        echo json_encode($data);
    }

    public function showLoginForm()
    {
        if (Helper::existsTempAuthInUrl()) {
            return $this->generateTokenByTemp();
        }

        $service      = new ApplicationService(new ApplicationRemoverItself());
        $applications = $service->getAllowedApplicationsToLogin();

        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);
        return $adapter->loadView('outsourced_login', compact('applications'));
    }
}