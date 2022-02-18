<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Services\AbstractService;
use Zevitagem\LegoAuth\Repositories\ConfigUserRepository;

class ConfigUserService extends AbstractService
{

    public function __construct()
    {
        parent::setRepository(new ConfigUserRepository());
    }

    public function getByUserAndSlug(int $userId, int $slug)
    {
        return $this->repository->getByUserAndSlug($userId, $slug);
    }
}