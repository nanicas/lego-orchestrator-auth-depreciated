<?php

namespace Zevitagem\LegoAuth\Services\Login;

use Zevitagem\LegoAuth\Traits\NavigateAsAppService;
use Zevitagem\LegoAuth\Services\Login\AbstractLoginService;
use Zevitagem\LegoAuth\Services\ApplicationService;
use Zevitagem\LegoAuth\Filters\ApplicationRemoverItself;

class LoginNotSourceService extends AbstractLoginService
{

    use NavigateAsAppService; 

    public function getDataOnShowLogin()
    {
        $service      = new ApplicationService(new ApplicationRemoverItself());
        $applications = $service->getAllowedApplicationsToLogin();

        return compact('applications');
    }
}