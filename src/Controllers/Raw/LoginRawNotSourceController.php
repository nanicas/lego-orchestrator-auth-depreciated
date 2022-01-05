<?php

namespace Zevitagem\LegoAuth\Controllers\Raw;

use Zevitagem\LegoAuth\Controllers\Raw\AbstractRawLoginController;
use Zevitagem\LegoAuth\Services\Login\LoginNotSourceService;
use Zevitagem\LegoAuth\Traits\NavigateAsAppController;
use \Zevitagem\LegoAuth\Traits\NotSourcedAuthActionsTrait;

class LoginRawNotSourceController extends AbstractRawLoginController
{

    use NavigateAsAppController,
        NotSourcedAuthActionsTrait;

    public function __construct()
    {
        $this->setService(new LoginNotSourceService());
    }

    public function index()
    {
        $this->showLoginForm();
    }
}