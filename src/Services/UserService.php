<?php

namespace Zevitagem\LegoAuth\Services;

use Zevitagem\LegoAuth\Services\AbstractService;
use Zevitagem\LegoAuth\Repositories\UserRepository;
use Zevitagem\LegoAuth\Helpers\Helper;
use GuzzleHttp\Client;

class UserService extends AbstractService
{

    public function __construct()
    {
        parent::setRepository(new UserRepository());
    }

    public function find(int $id)
    {
        return $this->getRepository()->find($id);
    }

    public function findInUrl(int $userId, string $url, string $token)
    {
        $client          = new Client(['headers' => ['Authorization' => $token]]);
        $requestResponse = $client->request('GET', $url.'/users/'.$userId);

        return Helper::extractJsonFromRequester($requestResponse);
    }
}