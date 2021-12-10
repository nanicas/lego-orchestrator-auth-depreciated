<?php

namespace App\Libraries\Annacode\Repositories;

use App\Libraries\Annacode\Repositories\AbstractRepository;
use App\Libraries\Annacode\Helpers\Helper;

class AuthorizationRepository extends AbstractRepository
{

    public function __construct()
    {
        $model = Helper::readConfig()['models']['authorization'];

        parent::setModel(new $model());
    }
}