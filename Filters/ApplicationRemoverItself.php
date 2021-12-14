<?php

namespace App\Libraries\Annacode\Filters;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Contracts\FilterContract;

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