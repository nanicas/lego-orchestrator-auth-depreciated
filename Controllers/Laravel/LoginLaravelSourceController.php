<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use Illuminate\Http\Request;
use App\Libraries\Annacode\Services\LoginSourceService;
use App\Libraries\Annacode\Controllers\Laravel\AbstractLaravelLoginController;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\FactoryAdapter;

class LoginLaravelSourceController extends AbstractLaravelLoginController
{
    private $authenticateData;

    public function __construct()
    {
        parent::__construct();

        $this->setService(new LoginSourceService());
    }

    public function showLoginForm()
    {
        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);
        return $adapter->loadView('login');
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