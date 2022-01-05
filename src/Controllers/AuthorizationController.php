<?php

namespace Zevitagem\LegoAuth\Controllers;

use App\Http\Controllers\Controller;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Traits\AvailabilityWithService;
use Zevitagem\LegoAuth\Services\AuthorizationService;

class AuthorizationController extends Controller
{
    use AvailabilityWithService;
    
    public function __construct()
    {
        $this->setService(new AuthorizationService());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function verify()
    {
        $data = $_POST['data'];

        try {
            $status = $this->service->checkIfExistsCode($data);
            $message = 'verified_with_success' . ( ($status) ? 'no_error' : 'containing_error' ) ;
        } catch (\Throwable $ex) {
            $status = false;
            $message = $ex->getMessage();
        }
        
        return json_encode(Helper::createDefaultJsonToResponse($status, ['message' => $message]));
    }
}
