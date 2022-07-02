<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

class SegmentL extends AbstractLaravelModel
{
    protected $fillable = [
        'name',
        'code',
        'active'
    ];

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->user_id;
    }

    public function isActive()
    {
        return boolval($this->active);
    }
}