<?php

namespace Zevitagem\LegoAuth\Repositories;

use Zevitagem\LegoAuth\Repositories\AbstractLaravelRepository;
use Zevitagem\LegoAuth\Helpers\Helper;

class AuthorizationRepository extends AbstractLaravelRepository
{
    public function __construct()
    {
        $model = Helper::readConfig()['models']['authorization'];

        parent::setModel(new $model());
    }
}