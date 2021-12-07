<?php

return [
    'auth_filler_middleware' => App\Libraries\Annacode\Middlewares\AuthFillerMiddleware::class,
    'is_laravel' => true,

    'route_prefix' => 'anc',
    'authenticable_middleware' => App\Libraries\Annacode\Middlewares\LaravelAuthenticateMiddleware::class,
    'user_api' => App\Libraries\Annacode\Controllers\Api\UserApiController::class
];

