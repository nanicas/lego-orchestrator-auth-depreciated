<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;
use Zevitagem\LegoAuth\Traits\Models\SlugModelTrait;

class SlugL extends AbstractLaravelModel
{
    use SlugModelTrait;
    
    protected $table = 'slugs';

    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'app_id',
        'name',
        'slug'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}