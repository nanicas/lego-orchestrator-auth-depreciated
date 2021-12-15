<?php

namespace App\Libraries\Annacode\Controllers\Laravel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Libraries\Annacode\Traits\AvailabilityWithService;
use App\Libraries\Annacode\Adapters\General\LaravelGeneralAdapter;
use App\Libraries\Annacode\Services\AuthorizationService;

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