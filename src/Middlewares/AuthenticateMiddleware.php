<?php

namespace Zevitagem\LegoAuth\Middlewares;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Helpers\ApiState;

class AuthenticateMiddleware
{

    public function handle($request, \Closure $next, ...$guards)
    {
//        if (empty(Helper::readConfig()['is_sourcer'])) {
//            return $next($request);
//        }

        $header = getallheaders();

        if (empty($header) || !isset($header['Authorization'])) {
            http_response_code(401);
            echo json_encode(
                Helper::createDefaultJsonToResponse(
                    false, ['message' => 'authorization_was_not_sent']
                )
            );
            exit;
        }

        $client = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL'),
            'headers' => ['Authorization' => $header['Authorization']]
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