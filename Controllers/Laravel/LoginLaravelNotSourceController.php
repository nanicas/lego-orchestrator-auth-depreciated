<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use App\Libraries\Annacode\Controllers\Laravel\AbstractLaravelLoginController;
use App\Libraries\Annacode\Services\LoginNotSourceService;
use App\Libraries\Annacode\Traits\NavigateAsAppController;

class LoginLaravelNotSourceController extends AbstractLaravelLoginController
{
    use NavigateAsAppController;
    
    public function __construct()
    {   
        parent::__construct();

        $this->setService(new LoginNotSourceService());
    }
    
}