<?php

namespace Zevitagem\LegoAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Zevitagem\LegoAuth\Traits\Models\AbstractModelTrait;

abstract class AbstractLaravelModel extends Model
{
    use AbstractModelTrait;
    
    const PRIMARY_KEY = 'id';

    public function getCreatedAt()
    {
        return $this->{$this->getCreatedAtColumn()};
    }

    public function getUpdatedAt()
    {
        return $this->{$this->getUpdatedAtColumn()};
    }
}