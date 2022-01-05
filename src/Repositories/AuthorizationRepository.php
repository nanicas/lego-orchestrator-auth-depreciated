<?php

namespace Zevitagem\LegoAuth\Repositories;

use Zevitagem\LegoAuth\Repositories\AbstractRepository;
use Zevitagem\LegoAuth\Helpers\Helper;

class AuthorizationRepository extends AbstractRepository
{

    public function __construct()
    {
        $model = Helper::readConfig()['models']['authorization'];

        parent::setModel(new $model());
    }
}