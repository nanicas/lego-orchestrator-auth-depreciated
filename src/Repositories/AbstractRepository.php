<?php

namespace Zevitagem\LegoAuth\Repositories;

use Zevitagem\LegoAuth\Contracts\RepositoryContract;
use Zevitagem\LegoAuth\Traits\AvailabilityWithDependencie;

abstract class AbstractRepository implements RepositoryContract
{
    use AvailabilityWithDependencie;

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
    
    protected function handle(string $dependencie, string $time, string $method, &$data)
    {
        $handler = $this->getDependencie($dependencie);
        $method = ucfirst($method);

        if (empty($handler) || !method_exists($handler, "{$time}{$method}")) {
            return $data;
        }
        
        $handler->setData($data);
        $handler->{"{$time}{$method}"}();
    }
}