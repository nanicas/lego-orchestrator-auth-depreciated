<?php

namespace Zevitagem\LegoAuth\Models\Laravel;

use Zevitagem\LegoAuth\Models\AbstractLaravelModel;
use Zevitagem\LegoAuth\Traits\Models\ApplicationModelTrait;

class ApplicationL extends AbstractLaravelModel
{
    use ApplicationModelTrait;
    
    protected $table = 'applications';

    protected $fillable = [
        'name',
        'domain',
        'id',
        'uuid',
        'active',
        'login_route',
        'site_route'
    ];

}