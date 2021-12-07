<?php

namespace App\Libraries\Annacode\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Annacode\Services\LoginSourceService;
use App\Libraries\Annacode\Controllers\AbstractLoginController;

class LoginSourceController extends AbstractLoginController
{
    private $authenticateData;

    public function __construct()
    {
        parent::__construct();

        $service = new LoginSourceService();
        $service->configureRepositories();

        $this->setService($service);
    }

    public function showLoginForm()
    {
        return view('annacode::login');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$this->isOutSourcedAccess()) {
            return;
        }

        $this->authenticateData = $this->getService()->getTempAuth(
            $user, $_POST['slug']
        );
    }

    public function redirectTo()
    {
        if (!$this->isOutSourcedAccess()) {
            return;
        }

        return $_POST['url_callback'].'?'.$this->authenticateData['params'];
    }
}