<?php

namespace App\Libraries\Annacode\Traits;

use App\Libraries\Annacode\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait AuthActionsTrait
{
    private $authenticateData = ['params' => ''];

    private function goSpecified(Request $request, $user)
    {
        if (!Helper::isOutSourcedAccess()) {
            return;
        }

        $this->authenticateData = $this->getAuthorizationService()->getTempAuth(
            $user, $_POST['slug']
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
            return;
        }

        return $_POST['url_callback'].'?'.$this->authenticateData['params'];
    }
}