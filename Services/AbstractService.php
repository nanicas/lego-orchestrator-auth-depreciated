<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Repositories\AbstractRepository;

abstract class AbstractService
{

    protected $repository;
    protected $dependencies = [];

    public function getRepository()
    {
        return $this->repository;
    }

    protected function setDependencie(string $key, $object)
    {
        $this->dependencies[$key] = $object;
    }

    protected function getDependencie(string $key)
    {
        return $this->dependencies[$key] ?? null;
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
