<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Services\AbstractService;
use App\Libraries\Annacode\Services\ApplicationService;

abstract class AbstractLoginService extends AbstractService
{
    public function __construct()
    {
        $this->setDependencie('app_service', new ApplicationService());
    }
    
    public function generateTempAuthInSourcer()
    {
        return $this->getDependencie('app_service')->generateTempAuthInSourcer();
    }
}