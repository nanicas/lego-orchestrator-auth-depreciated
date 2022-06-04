<?php

use Zevitagem\LegoAuth\Helpers\Helper;

$config = Helper::readConfig();

Helper::loadLaravelLegoRoutes($config,
    [
        'login_controller' => \App\Http\Controllers\Auth\LoginController::class
    ]
);