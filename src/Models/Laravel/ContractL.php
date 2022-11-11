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
        'user_id',
        'slug',
        'active',
        'slug_name',
        'site_route',
        'application_name',
        'application_domain',
        'segment_id',
        'segment_name',
        'segment_code',
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
    
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getSlugName()
    {
        return $this->slug_name;
    }
    
    public function getSlugId()
    {
        return $this->slug_id;
    }

    public function getSegmentName()
    {
        return (empty($this->segment_name)) ? 'Nenhum' : $this->segment_name;
    }

    public function getSegmentCode()
    {
        return $this->segment_code;
    }

    public function getSegmentId()
    {
        return $this->segment_id;
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