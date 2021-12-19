<?php

namespace App\Libraries\Annacode\Controllers\Raw;

use App\Libraries\Annacode\Controllers\Raw\AbstractRawLoginController;
use App\Libraries\Annacode\Services\Login\LoginNotSourceService;
use App\Libraries\Annacode\Traits\NavigateAsAppController;
use \App\Libraries\Annacode\Traits\NotSourcedAuthActionsTrait;

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