<?php

namespace App\Libraries\Annacode\Repositories;

use App\Libraries\Annacode\Repositories\AbstractRepository;
use App\Libraries\Annacode\Models\Authorization;

class AuthorizationRepository extends AbstractRepository
{

    public function __construct()
    {
        parent::setModel(new Authorization());
    }
}
