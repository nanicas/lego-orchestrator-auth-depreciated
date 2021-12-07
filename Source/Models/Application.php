<?php

namespace App\Libraries\Annacode\Models;

use App\Models\AbstractModel;

class Application extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'url',
        'id',
        'active'
    ];
    
    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRoute()
    {
        return $this->url;
    }
}
