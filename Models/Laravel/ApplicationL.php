<?php

namespace App\Libraries\Annacode\Models\Laravel;

use App\Libraries\Annacode\Models\AbstractLaravelModel;
use App\Libraries\Annacode\Traits\Models\ApplicationModelTrait;

class ApplicationL extends AbstractLaravelModel
{

    use ApplicationModelTrait;
    
    protected $table    = 'applications';

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
    ];

}