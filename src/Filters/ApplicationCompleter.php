<?php

namespace Zevitagem\LegoAuth\Filters;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Contracts\FilterContract;

class ApplicationCompleter implements FilterContract
{

    public function filter($data)
    {
        return $data;
    }
}