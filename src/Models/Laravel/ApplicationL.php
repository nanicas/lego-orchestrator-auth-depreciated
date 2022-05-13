<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;
use Zevitagem\LegoAuth\Traits\Models\ApplicationModelTrait;

class ApplicationL extends AbstractLaravelModel
{

    use ApplicationModelTrait;
    
    protected $table = 'applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'domain',
        'id',
        'active',
        'login_route',
        'site_route'
    ];

}