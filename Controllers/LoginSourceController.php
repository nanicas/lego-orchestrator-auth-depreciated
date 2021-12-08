<?php

namespace App\Libraries\Annacode\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Annacode\Services\LoginSourceService;
use App\Libraries\Annacode\Controllers\AbstractLoginController;
use App\Libraries\Annacode\Helpers\Helper;

class LoginSourceController extends AbstractLoginController
{
    private $authenticateData;

    public function __construct()
    {
        parent::__construct();

        $this->setService(new LoginSourceService());
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

    public function generateTempAuthByToken()
    {
        Helper::defaultExecutationToReplyJson(function () {
            return $this->getService()->getTempAuthByToken();
        });
    }
}