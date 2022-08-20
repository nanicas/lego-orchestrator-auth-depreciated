<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

class ScopeL extends AbstractLaravelModel
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
        'code',
        'rule_id',
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
    
    public function getCode()
    {
        return $this->code;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getRuleId()
    {
        return $this->rule_id;
    }

    public function isActive()
    {
        return boolval($this->active);
    }
}