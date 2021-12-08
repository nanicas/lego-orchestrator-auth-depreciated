<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Services\AuthorizationService;
use App\Libraries\Annacode\Services\AbstractLoginService;
use App\Libraries\Annacode\Helpers\ApiState;
use App\Libraries\Annacode\Services\UserService;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientService
 *
 * @author Joseph
 */
class LoginSourceService extends AbstractLoginService
{

    public function __construct()
    {
        parent::__construct();

        $this->setDependencie('auth_service', new AuthorizationService());
        $this->setDependencie('user_service', new UserService());
    }

    public function getTempAuth($user, $slug)
    {
        return $this->getDependencie('auth_service')->getTempAuth($user, $slug);
    }

    public function getTempAuthByToken()
    {
        $state = ApiState::all();

        $user = $this->getDependencie('user_service')->find($state['user_id']);

        return $this->getDependencie('auth_service')->getTempAuth($user, $state['slug']);
    }
}