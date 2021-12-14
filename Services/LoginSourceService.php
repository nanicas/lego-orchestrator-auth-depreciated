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

    public function getTempAuth($user, $slug)
    {
        $service = new AuthorizationService();

        return $service->getTempAuth($user, $slug);
    }

    public function getTempAuthByToken()
    {
        $state   = ApiState::all();
        $service = new UserService();

        $user = $service->find($state['user_id']);

        return $this->getTempAuth($user, $state['slug']);
    }
}