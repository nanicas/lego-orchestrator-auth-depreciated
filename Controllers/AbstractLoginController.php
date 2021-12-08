<?php

namespace App\Libraries\Annacode\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Libraries\Annacode\Contracts\HaveMyOwnAuthenticationContract;
use Illuminate\Support\Facades\View;
use App\Libraries\Annacode\Traits\AvailabilityWithService;
use App\Libraries\Annacode\Helpers\Helper;

class AbstractLoginController extends Controller
{

    use AuthenticatesUsers,
        AvailabilityWithService;

    public function __construct()
    {
        View::addNamespace(
            'annacode', app_path().'/Libraries/Annacode/Views'
        );
    }

    public function isSourceAuthorization()
    {
        $interfaces = class_implements($this);

        return (isset($interfaces[HaveMyOwnAuthenticationContract::class]));
    }

    public function isOutSourcedAccess()
    {
        return (!empty($_POST['url_callback']));
    }

    public function existsTempAuth()
    {
        return (!empty($_GET['token']));
    }

    public function generateTempAuthInSourcer()
    {
        Helper::defaultExecutationToReplyJson(function () {
            return $this->service->generateTempAuthInSourcer()['response'];
        });
    }
}