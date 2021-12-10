<?php

namespace App\Libraries\Annacode\Repositories;

use App\Libraries\Annacode\Repositories\AbstractRepository;
use App\Libraries\Annacode\Helpers\Helper;

class UserRepository extends AbstractRepository
{

    public function __construct()
    {
        $model = Helper::readConfig()['models']['user'];

        parent::setModel(new $model());
    }
}