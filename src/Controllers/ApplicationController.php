<?php

namespace Zevitagem\LegoAuth\Controllers;

use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Services\SlugService;
use Illuminate\Http\Request;
use Zevitagem\LegoAuth\Traits\AvailabilityWithView;

class ApplicationController
{

    use AvailabilityWithView;

    public function __construct()
    {
        $this->addViewNamespace();
    }

    public function slugs(Request $request)
    {
        $route = $request->query('login_route');

        try {
            $service = new SlugService();
            $slugs   = $service->getSlugsByApplication($request->route('app'));
            $status  = true;
            $message = '';
        } catch (\Throwable $ex) {
            $status  = false;
            $message = $ex->getMessage();
            $slugs   = [];
        }

        return json_encode(Helper::createDefaultJsonToResponse($status,
                [
                    'html' => Helper::getGeneralAdapter()->loadView(
                        'slugs_list', compact('route', 'slugs', 'message', 'status')
                    )->render()
                ]
        ));
    }
}