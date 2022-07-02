<?php

namespace Zevitagem\LegoAuth\Repositories;

use Zevitagem\LegoAuth\Contracts\RepositoryContract;

abstract class AbstractRepository implements RepositoryContract
{
    protected $model;

    protected function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getClassModel()
    {
        return get_class($this->model);
    }

    public function getTable()
    {
        return $this->model->getTable();
    }

    public function getPrimaryKey()
    {
        return $this->model::getPrimaryKey();
    }
}