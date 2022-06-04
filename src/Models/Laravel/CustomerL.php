<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;

class CustomerL extends AbstractLaravelModel
{
    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'user_id',
        'active',
        'created_at',
        'activated_at',
        'deactivated_at',
        'deleted_at',
    ];
    
    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
        'activated_at' => 'datetime',
        'deactivated_at' => 'datetime'
    ];

}