<?php

namespace App\Libraries\Annacode\Repositories;

use App\Libraries\Annacode\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository
{

    public function __construct()
    {
        parent::setModel(new \App\Models\User());
    }
}