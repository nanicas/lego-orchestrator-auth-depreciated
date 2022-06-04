<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

class ConfigUserL extends AbstractLaravelModel
{
    protected $fillable = [
        'name',
        'user_id',
        'slug',
        'admin'
    ];

    public function getName()
    {
        return $this->name;
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function isAdmin()
    {
        return ($this->admin == 1);
    }
}