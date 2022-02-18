<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Services\AbstractService;
use Zevitagem\LegoAuth\Repositories\UserRepository;

class UserService extends AbstractService
{

    public function __construct()
    {
        parent::setRepository(new UserRepository());
    }

    public function find(int $id)
    {
        return $this->getRepository()->find($id);
    }
}