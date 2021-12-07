<?php

namespace App\Libraries\Annacode\Controllers;

use App\Libraries\Annacode\Services\ApplicationService;
use App\Libraries\Annacode\Controllers\AbstractLoginController;
use App\Libraries\Annacode\Services\LoginNotSourceService;
use \App\Libraries\Annacode\Traits\NavigateAsAppController;

class LoginNotSourceController extends AbstractLoginController
{
    use NavigateAsAppController;
    
    public function __construct()
    {
        parent::__construct();

        $this->setService(new LoginNotSourceService());
    }

    public function showLoginForm()
    {
        if ($this->existsTempAuth()) {
            return $this->generateTokenByTemp();
        }
        
        $service      = new ApplicationService();
        $applications = $service->getAllowedApplicationsToLogin();

        return view('annacode::outsourced_login', compact('applications'));
    }
}