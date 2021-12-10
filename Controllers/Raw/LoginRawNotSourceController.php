<?php

namespace App\Libraries\Annacode\Controllers\Raw;

use App\Libraries\Annacode\Controllers\Raw\AbstractRawLoginController;
use App\Libraries\Annacode\Services\LoginNotSourceService;
use App\Libraries\Annacode\Traits\NavigateAsAppController;

class LoginRawNotSourceController extends AbstractRawLoginController
{

    use NavigateAsAppController;

    public function __construct()
    {
        $this->setService(new LoginNotSourceService());
    }

    public function index()
    {
        $this->showLoginForm();
    }
}