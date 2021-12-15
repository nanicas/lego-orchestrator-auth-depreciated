<?php

namespace App\Libraries\Annacode\Services\Login;

use App\Libraries\Annacode\Traits\NavigateAsAppService;
use App\Libraries\Annacode\Services\Login\AbstractLoginService;
use App\Libraries\Annacode\Services\ApplicationService;
use App\Libraries\Annacode\Filters\ApplicationRemoverItself;

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