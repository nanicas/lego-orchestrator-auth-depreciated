<?php

namespace Zevitagem\LegoAuth\Repositories;

use Throwable;
use Zevitagem\LegoAuth\Repositories\AbstractRepository;
use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

abstract class AbstractLaravelRepository extends AbstractRepository
{
    public function __call($name, $arguments)
    {
        try {
            return $this->getModel()->{$name}(...$arguments);
        } catch (Throwable $exc) {
            return $exc;
        }
    }

    public function store(array $data)
    {
        return $this->getModel()->create($data);
    }

    //public function update(AbstractLaravelModel $object)
    public function update($object)
    {
        return $object->save();
    }

    public function getById(int $id)
    {
        return $this->getModel()->find($id);
    }
}