<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use Zevitagem\LegoAuth\Controllers\Laravel\AbstractLoginLaravelController;
use Zevitagem\LegoAuth\Services\Login\LoginNotSourceService;
use Zevitagem\LegoAuth\Traits\NavigateAsAppController;
use \Zevitagem\LegoAuth\Traits\NotSourcedAuthActionsTrait;

class LoginLaravelNotSourceController extends AbstractLoginLaravelController
{
    use NavigateAsAppController,
        NotSourcedAuthActionsTrait;

    public function __construct()
    {
        parent::__construct();
        
        $this->setService(new LoginNotSourceService());
    }
}