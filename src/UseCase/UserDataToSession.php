<?php

namespace Zevitagem\LegoAuth\UseCase;

use Zevitagem\LegoAuth\Services\ConfigUserService;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityToGetUserDataException;
use GuzzleHttp\Client;

class UserDataToSession
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    private function getInternalConfigUser(int $userId, int $slug)
    {
        $configService = new ConfigUserService();
        $config = $configService->getByUserAndSlug($userId, $slug);

        return (is_object($config)) ? $config->toArray() : null;
    }

    public function getConfigUser()
    {
        list(
            'user_id' => $userId,
            'slug' => $slug,
            'requester' => $requester,
            'token' => $token,
            ) = $this->config;

        if (empty($userId) || empty($slug) || empty($requester) || empty($token)) {
            throw new \InvalidArgumentException();
        }

        if (Helper::isLaravel()) {
            return $this->getInternalConfigUser($userId, $slug);
        }
        
        $client = new Client(['headers' => ['Authorization' => $token]]);
        $requestResponse = $client->request('GET',
            $requester['internal_api_url'].'/config_users/'.$userId.'/'.$slug
        );

        $response = Helper::extractJsonFromRequester($requestResponse);

        return ($response['status'] == false) ? null : $response['response'];
    }

    public function getUser()
    {
        list(
            'user_id' => $userId,
            'authenticator' => $authenticator,
            'token' => $token,
            ) = $this->config;

        if (empty($userId) || empty($authenticator) || empty($token)) {
            throw new \InvalidArgumentException();
        }
        
        $client = new Client(['headers' => ['Authorization' => $token]]);
        $requestResponse = $client->request('GET',
            $authenticator['internal_api_url'].'/users/'.$userId
        );

        $response = Helper::extractJsonFromRequester($requestResponse);

        if ($response['status'] == false) {
            throw new ImpossibilityToGetUserDataException($response['response']['message']);
        }

        return $response['response'];
    }
}