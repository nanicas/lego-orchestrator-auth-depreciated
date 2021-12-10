<?php
return [
    'middlewares' => [
        'auth_filler_middleware' => App\Libraries\Annacode\Middlewares\AuthFillerMiddleware::class,
        'authenticable_middleware' => App\Libraries\Annacode\Middlewares\AuthenticateMiddleware::class,
    ],
    'models' => [
        'application' => \App\Libraries\Annacode\Models\Laravel\ApplicationL::class,
        'authorization' => \App\Libraries\Annacode\Models\Laravel\AuthorizationL::class,
        'user' => App\Models\User::class
    ],
    'user_api' => App\Libraries\Annacode\Controllers\Api\UserApiController::class,
    'is_sourcer' => false,
    'is_laravel' => true,
    'route_prefix' => 'anc',
];

