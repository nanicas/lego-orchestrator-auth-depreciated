<?php

namespace Zevitagem\LegoAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Zevitagem\LegoAuth\Traits\Models\ApplicationModelTrait;

abstract class AbstractLaravelModel extends Model
{
    use ApplicationModelTrait;
    
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