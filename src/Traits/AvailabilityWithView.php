<?php

namespace Zevitagem\LegoAuth\Traits;

use Illuminate\Support\Facades\View;
use Zevitagem\LegoAuth\Adapters\General\LaravelGeneralAdapter;

trait AvailabilityWithView
{
    private $service;

    protected function addViewNamespace()
    {
        View::addNamespace(
            LaravelGeneralAdapter::getViewPrefix(),
            resource_path('views/'.LaravelGeneralAdapter::getViewPath())
        );
    }
}