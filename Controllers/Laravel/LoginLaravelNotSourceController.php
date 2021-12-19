<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use App\Libraries\Annacode\Controllers\Laravel\AbstractLoginLaravelController;
use App\Libraries\Annacode\Services\Login\LoginNotSourceService;
use App\Libraries\Annacode\Traits\NavigateAsAppController;
use \App\Libraries\Annacode\Traits\NotSourcedAuthActionsTrait;

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