<?php

namespace Zevitagem\LegoAuth\Middlewares;

use Zevitagem\LegoAuth\Helpers\Helper;
use Illuminate\Http\Request;
use Zevitagem\LegoAuth\Staters\AppStater;
use Zevitagem\LegoAuth\Repositories\PainelRepository;
use Illuminate\Support\Facades\Auth;

class FillerSingletonStateMiddleware
{
    private $painelRepository;

    public function __construct(PainelRepository $painelRepository)
    {
        $this->painelRepository = $painelRepository;
    }

    public function handle(Request $request, \Closure $next)
    {
        try {
            if (Auth::check()) {

                $config = Helper::getUserConfig();
                $scopes = [];

                if (!empty($config)) {
                    $scopes = $this->painelRepository->getScopesByRule($config['rule_id']);
                }

                AppStater::setItem('user_config', $config);
                AppStater::setItem('scopes', $scopes);
            }
        } finally {
            return $next($request);
        }
    }
}
