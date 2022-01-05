<?php

namespace Zevitagem\LegoAuth\Filters;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Contracts\FilterContract;

class ApplicationRemoverItself implements FilterContract
{

    public function filter($data)
    {
        $appId = Helper::getAppId();

        $list = [];
        foreach ($data as $application) {
            if ($application->getId() != $appId) {
                $list[] = $application;
            }
        }
        
        return $list;
    }
}