<?php

namespace Zevitagem\LegoAuth\Repositories;

use Zevitagem\LegoAuth\Repositories\AbstractLaravelRepository;
use Zevitagem\LegoAuth\Helpers\Helper;

class UserRepository extends AbstractLaravelRepository
{
    public function __construct()
    {
        $model = Helper::readConfig()['models']['user'];

        parent::setModel(new $model());
    }
}