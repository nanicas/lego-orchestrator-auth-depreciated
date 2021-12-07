<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Services\AuthorizationService;
use App\Libraries\Annacode\Repositories\AuthorizationRepository;
use App\Libraries\Annacode\Services\AbstractService;
use App\Libraries\Annacode\Services\LoginConfig;

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
class LoginSourceService extends AbstractService
{

    public function __construct()
    {
        $this->config = new LoginConfig();
    }

    public function configureRepositories(array $repos = [])
    {
        $this->setDependencie(
            'auth', $repos['auth'] ?? AuthorizationRepository::class
        );
    }

    public function getTempAuth($user, $slug)
    {
        $repository           = $this->getDependencie('auth');
        $authorizationService = new AuthorizationService(new $repository());

        return $authorizationService->getTempAuth($user, $slug);
    }
}