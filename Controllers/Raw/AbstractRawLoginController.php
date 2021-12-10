<?php

namespace App\Libraries\Annacode\Controllers\Raw;

use App\Libraries\Annacode\Traits\AvailabilityWithService;
use App\Libraries\Annacode\Traits\Login\CommonActionsInLoginControllerTrait;

class AbstractRawLoginController
{

    use AvailabilityWithService,
        CommonActionsInLoginControllerTrait;
}