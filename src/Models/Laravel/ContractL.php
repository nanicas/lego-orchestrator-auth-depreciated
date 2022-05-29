<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

class ContractL extends AbstractLaravelModel
{
    const UPDATED_AT = null;
    const PRIMARY_KEY = 'id';

    protected $fillable = [
        'id',
        'slug_id',
        'app_id',
        'slug',
        'active',
        'slug_name',
        'created_at'
    ];

    public function getSlug()
    {
        return $this->slug;
    }

    public function getApplicationId()
    {
        return $this->app_id;
    }

    public function getSlugName()
    {
        return $this->slug_name;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function isActive()
    {
        return ($this->active == 1);
    }
}