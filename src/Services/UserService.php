<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Services\AbstractService;
use Zevitagem\LegoAuth\Repositories\UserRepository;

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
class UserService extends AbstractService
{

    public function __construct()
    {
        parent::setRepository(new UserRepository());
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }
}