<?php

namespace App\Libraries\Annacode\Traits\Login;

use App\Libraries\Annacode\Contracts\HaveMyOwnAuthenticationContract;
use App\Libraries\Annacode\Services\ApplicationService;
use App\Libraries\Annacode\Adapters\FactoryAdapter;

trait CommonActionsInLoginControllerTrait
{

//    public function isSourceAuthorization()
//    {
//        $interfaces = class_implements($this);
//
//        return (isset($interfaces[HaveMyOwnAuthenticationContract::class]));
//    }

    public function isOutSourcedAccess()
    {
        return (!empty($_POST['url_callback']));
    }

    public function existsTempAuth()
    {
        return (!empty($_GET['token']));
    }

    public function generateTempAuthInSourcer()
    {
        $data = $this->service->generateTempAuthInSourcer();

        echo json_encode($data);
    }

    public function showLoginForm()
    {
        if ($this->existsTempAuth()) {
            return $this->generateTokenByTemp();
        }

        $service      = new ApplicationService();
        $applications = $service->getAllowedApplicationsToLogin();

        $adapter = FactoryAdapter::instance(FactoryAdapter::GENERAL_TYPE);
        return $adapter->loadView('outsourced_login', compact('applications'));
    }
}