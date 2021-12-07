<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Services\AbstractService;
use GuzzleHttp\Client;
use App\Libraries\Annacode\Repositories\AuthorizationRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientService
 *
 * @author Joseph
 */
class AuthorizationService extends AbstractService
{

    public function __construct()
    {
        $this->setRepository(new AuthorizationRepository());
    }

    public function getTempAuth($user, $slug)
    {
        $userId = $user->id;
        $owdId = Helper::getAppId();

        $authorization = $this->getRepository()->getModel();
        $authorization->code = uniqid();
        $authorization->user_id = $userId;
        $authorization->save();

        $client = new Client(['base_uri' => env('AUTHORIZATION_APP_URL')]);

        $encryptToSend = Helper::encryptDifferentiated(json_encode([
            'user_id' => $userId,
            'authorization_code' => $authorization->code,
            'app_own_id' => $owdId,
            'slug' => $slug
        ]), env('AUTHORIZATION_PUBLIC_KEY'));

        $response = $client->post('?action=generateTempToken', [
            'form_params' => [
                'data' => $encryptToSend
            ]
        ]);

        $response = Helper::extractJsonFromRequester($response);
        if ($response['status'] == false) {
            return $response;
        }

        $params = http_build_query([
            'token' => $response['response']['token'],
            'sessionId' => Helper::generateUniqueSessionIdentifier($owdId, $slug, $userId)
        ]);

        return [
            'params' => $params,
            'status' => true
        ];
    }

    public function checkIfExistsCode(string $data)
    {
        $decrypted     = Helper::decryptDifferentiated($data, env('PRIVATE_KEY'));
        $decryptedJson = json_decode($decrypted, true);

        $model = $this->repository->getModel();

        $exists = $model
            ->where('code', $decryptedJson['code'])
            ->where('user_id', $decryptedJson['user_id'])
            ->exists();

        if ($exists == false) {
            return false;
        }

//        $model
//            ->where('code', $decryptedJson['code'])
//            ->where('user_id', $decryptedJson['user_id'])
//            ->limit(1)
//            ->update(['verified_at' => now()]);

        return true;
    }
}