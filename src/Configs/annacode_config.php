<?php
return [
    'middlewares' => [
        'auth_filler_middleware' => Zevitagem\LegoAuth\Middlewares\AuthFillerMiddleware::class,
        'authenticable_middleware' => Zevitagem\LegoAuth\Middlewares\AuthenticateMiddleware::class,
    ],
    'models' => [
        'application' => \Zevitagem\LegoAuth\Models\Laravel\ApplicationL::class,
        'authorization' => \Zevitagem\LegoAuth\Models\Laravel\AuthorizationL::class,
        'slug' => \Zevitagem\LegoAuth\Models\Laravel\SlugL::class,
        'user' => App\Models\User::class
    ],
    'user_api' => Zevitagem\LegoAuth\Controllers\Api\UserApiController::class,
    'config_user_api' => \Zevitagem\LegoAuth\Controllers\Api\ConfigUserApiController::class,
    'is_sourcer' => false,
    'is_laravel' => true,
    'package' => 'anc',
    'api_group' => 'api',
    'slugs_inside' => false,
    'pages' => [
        'user_config' => true
    ]
];