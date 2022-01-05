<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Zevitagem\LegoAuth\Traits\AvailabilityWithService;
use Zevitagem\LegoAuth\Adapters\General\LaravelGeneralAdapter;
use Zevitagem\LegoAuth\Services\AuthorizationService;

abstract class AbstractAuthLaravelController extends Controller
{

    use AvailabilityWithService;
    
    protected $authorizationService;

    public function __construct()
    {
        $this->authorizationService = new AuthorizationService();

        View::addNamespace(
            LaravelGeneralAdapter::getViewPrefix(),
            resource_path('views/'.LaravelGeneralAdapter::getViewPath())
        );
    }

    public function getAuthorizationService()
    {
        return $this->authorizationService;
    }
}