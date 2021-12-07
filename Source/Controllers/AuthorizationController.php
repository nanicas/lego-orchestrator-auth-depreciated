<?php

namespace App\Libraries\Annacode\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Traits\AvailabilityWithService;
use App\Libraries\Annacode\Services\AuthorizationService;

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
            $message = 'verified_with_success';
        } catch (\Throwable $ex) {
            $status = false;
            $message = $ex->getMessage();
        }
        
        return json_encode(Helper::createDefaultJsonToResponse($status, ['message' => $message]));
    }
}
