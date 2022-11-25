<?php

namespace Zevitagem\LegoAuth\Traits;

use Zevitagem\LegoAuth\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

trait AuthActionsTrait
{
    private $authenticateData = ['params' => ''];

    private function goSpecified(Request $request, $user)
    {
        if (!Helper::isOutSourcedAccess()) {
            return;
        }

        $this->authenticateData = $this->getAuthorizationService()->getTempAuth(
            $user, $_POST['slug'], $_POST['app_requester_id']
        );

        Auth::logout();
    }

    protected function registered(Request $request, $user)
    {
        return $this->goSpecified($request, $user);
    }

    protected function authenticated(Request $request, $user)
    {
        return $this->goSpecified($request, $user);
    }

    public function redirectTo()
    {
        if (!Helper::isOutSourcedAccess()) {
            return property_exists($this, 'redirectTo') ? $this->redirectTo : RouteServiceProvider::HOME;
        }

        $end = $this->authenticateData['params'] ?? '';
        if ($this->authenticateData['status'] == false) {
            $end = 'message='.json_encode($this->authenticateData['response']['message']);
        }
        
        return $_POST['url_callback'].'?'.$end;
    }
}