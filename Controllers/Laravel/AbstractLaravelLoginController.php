<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\View;
use App\Libraries\Annacode\Traits\AvailabilityWithService;
use App\Libraries\Annacode\Traits\CommonActionsInLoginControllerTrait;
use App\Libraries\Annacode\Adapters\General\LaravelGeneralAdapter;

class AbstractLaravelLoginController extends Controller
{

    use AuthenticatesUsers,
        AvailabilityWithService,
        CommonActionsInLoginControllerTrait {
        CommonActionsInLoginControllerTrait::showLoginForm insteadof AuthenticatesUsers;
    }

    public function __construct()
    {
        View::addNamespace(
            LaravelGeneralAdapter::getViewPrefix(),
            resource_path('views/' .LaravelGeneralAdapter::getViewPath())
        );
    }
}