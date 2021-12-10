<?php

namespace App\Libraries\Annacode\Middlewares;

use GuzzleHttp\Client;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Helpers\ApiState;

class AuthenticateMiddleware
{

    public function handle($request, \Closure $next, ...$guards)
    {
        if (empty(Helper::readConfig()['is_sourcer'])) {
            return $next($request);
        }

        $header = getallheaders()['Authorization'];

        if (empty($header)) {
            echo json_encode(Helper::createDefaultJsonToResponse(false,
                    ['message' => 'authorization_was_not_sent']));
            exit();
        }

        $client = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL'),
            'headers' => ['Authorization' => $header]
        ]);

        $responseRequest = $client->get('?action=verifyAccess');

        $response = Helper::extractJsonFromRequester($responseRequest);
        if ($response['status'] == false) {
            return $response;
        }

        ApiState::instance($response['response']);

        return $next($request);
    }
}