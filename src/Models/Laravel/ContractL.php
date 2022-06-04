<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

class ContractL extends AbstractLaravelModel
{
    const UPDATED_AT  = null;

    protected $fillable = [
        'id',
        'slug_id',
        'app_id',
        'slug',
        'active',
        'slug_name',
        'site_route',
        'application_name',
        'application_domain',
        'created_at'
    ];

    public function getSlug()
    {
        return $this->slug;
    }

    public function getApplicationName()
    {
        return $this->application_name;
    }

    public function getApplicationId()
    {
        return $this->app_id;
    }

    public function getSlugName()
    {
        return $this->slug_name;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function isActive()
    {
        return ($this->active == 1);
    }

    public function getSiteRoute()
    {
        return $this->site_route;
    }

    public function getUrl()
    {
        return $this->application_domain.''.$this->site_route.'/'.$this->getSlug();
    }
}