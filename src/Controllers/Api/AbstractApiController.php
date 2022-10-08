<?php

namespace Zevitagem\LegoAuth\Controllers\Api;

use App\Http\Controllers\Controller;
use Zevitagem\LegoAuth\Helpers\Helper;
//use Zevitagem\LegoAuth\Contracts\ApiResourceFactoryContract;

class AbstractApiController extends Controller
{
    public function __call($name, $arguments)
    {
        Helper::defaultExecutationToReplyJson(function () use ($name, $arguments) {
            $service = $this->getService();

//            if (!method_exists($service, $name)) {
//                throw new \InvalidArgumentException("The route/action {$name} don't exists in service");
//            }

            return $service->{$name}(...$arguments);
        });
    }
}