<?php

namespace App\Libraries\Annacode\Models;

use App\Libraries\Annacode\Models\AbstractModel;

class Authorization extends AbstractModel
{
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

    public function getCode()
    {
        return $this->code;
    }
}