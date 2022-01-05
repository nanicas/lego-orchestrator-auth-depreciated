<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;
use Zevitagem\LegoAuth\Traits\Models\AuthorizationModelTrait;

class AuthorizationL extends AbstractLaravelModel
{

    use AuthorizationModelTrait;

    protected $table    = 'authorizations';
    
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'verified_at' => 'datetime',
    ];

}