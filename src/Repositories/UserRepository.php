<?php

namespace Zevitagem\LegoAuth\Repositories;

use Zevitagem\LegoAuth\Repositories\AbstractRepository;
use Zevitagem\LegoAuth\Helpers\Helper;

class UserRepository extends AbstractRepository
{

    public function __construct()
    {
        $model = Helper::readConfig()['models']['user'];

        parent::setModel(new $model());
    }
}