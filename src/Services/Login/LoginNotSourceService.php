<?php

namespace Zevitagem\LegoAuth\Services\Login;

use Zevitagem\LegoAuth\Traits\NavigateAsAppService;
use Zevitagem\LegoAuth\Services\Login\AbstractLoginService;
use Zevitagem\LegoAuth\Services\ApplicationService;
use Zevitagem\LegoAuth\Filters\ApplicationRemoverItself;
use Zevitagem\LegoAuth\Helpers\Helper;

class LoginNotSourceService extends AbstractLoginService
{

    use NavigateAsAppService; 

    public function getDataOnShowLogin()
    {
        $config = Helper::readConfig();

        $service = new ApplicationService();
        $service->setFilter(new ApplicationRemoverItself());
        
        $applications = $service->getAllowedApplicationsToLogin();
        $slugs = $this->getSlugs([
            'with_slugs' => (string) ((int) ($config['slugs_inside'] === true && Helper::isLaravel()))
        ]);

        return compact('applications', 'slugs');
    }
}