<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

class RuleL extends AbstractLaravelModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'description',
        'active',
        'app_id',
        'created_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'active' => 'boolean'
    ];
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getApplicationId()
    {
        return $this->app_id;
    }

    public function isActive()
    {
        return boolval($this->active);
    }
}