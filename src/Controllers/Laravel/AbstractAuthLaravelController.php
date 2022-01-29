<?php

namespace Zevitagem\LegoAuth\Controllers\Laravel;

use App\Http\Controllers\Controller;
use Zevitagem\LegoAuth\Traits\AvailabilityWithService;
use Zevitagem\LegoAuth\Services\AuthorizationService;
use Zevitagem\LegoAuth\Traits\AvailabilityWithView;

abstract class AbstractAuthLaravelController extends Controller
{

    use AvailabilityWithService,
        AvailabilityWithView;
    
    protected $authorizationService;

    public function __construct()
    {
        $this->authorizationService = new AuthorizationService();

        $this->addViewNamespace();
    }

    public function getAuthorizationService()
    {
        return $this->authorizationService;
    }
}