<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Repositories\AbstractRepository;
use Zevitagem\LegoAuth\Traits\AvailabilityWithDependencie;

abstract class AbstractService
{
    use AvailabilityWithDependencie;
    
    protected $repository;

    public function getRepository()
    {
        return $this->repository;
    }

    protected function setRepository(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTable()
    {
        return $this->repository->getTable();
    }

    public function getColumnsObject()
    {
        return $this->repository->getColumnsObject();
    }

    public function showColumns(string $table = '')
    {
        $data = $this->repository->showColumns($table);

        return array_map(function ($item) {
            return $item['Field'];
        }, $data);
    }

}
