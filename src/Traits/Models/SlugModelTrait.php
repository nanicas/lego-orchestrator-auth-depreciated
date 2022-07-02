<?php

namespace Zevitagem\LegoAuth\Traits\Models;

trait SlugModelTrait
{

    public function getId()
    {
        return $this->id;
    }
    
    public function getApp()
    {
        return $this->app_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getSegmentId()
    {
        return $this->segment_id;
    }
}