<?php
return [
    'middlewares' => [
        'auth_filler_middleware' => Zevitagem\LegoAuth\Middlewares\AuthFillerMiddleware::class,
        'authenticable_middleware' => Zevitagem\LegoAuth\Middlewares\AuthenticateMiddleware::class,
        'filler_singleton_state_middleware' => Zevitagem\LegoAuth\Middlewares\FillerSingletonStateMiddleware::class,
    ],
    'models' => [
        'user' => App\Models\User::class,
        
        'application' => \Zevitagem\LegoAuth\Models\Laravel\ApplicationL::class,
        'authorization' => \Zevitagem\LegoAuth\Models\Laravel\AuthorizationL::class,
        'config_user' => \Zevitagem\LegoAuth\Models\Laravel\ConfigUserL::class,
        'contract' => \Zevitagem\LegoAuth\Models\Laravel\ContractL::class,
        'slug' => \Zevitagem\LegoAuth\Models\Laravel\SlugL::class,
        'rule' => \Zevitagem\LegoAuth\Models\Laravel\RuleL::class,
    ],
    'api_group' => 'api',
    'config_user_api' => \Zevitagem\LegoAuth\Controllers\Api\ConfigUserApiController::class,
    'user_api' => \Zevitagem\LegoAuth\Controllers\Api\UserApiController::class,
    'is_sourcer' => true,
    'is_laravel' => true,
    'package' => 'anc',
    'pages' => [
        'user_config' => true
    ],
    'slugs_inside' => false
];