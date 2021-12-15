<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Services\AbstractService;
use App\Libraries\Annacode\Repositories\AuthorizationRepository;
use App\Libraries\Annacode\Services\UserService;
use App\Libraries\Annacode\Exceptions\NotFoundInDatabaseException;
use App\Libraries\Annacode\Services\SessionService;
use GuzzleHttp\Client;
use App\Libraries\Annacode\Exceptions\ImpossibilityGenerateTokenByTokenException;

class AuthorizationService extends AbstractService
{

    public function __construct()
    {
        $this->setRepository(new AuthorizationRepository());
    }

    public function getTempAuth($user, $slug)
    {
        $userId = $user->id;
        $owdId  = Helper::getAppId();

        $authorization          = $this->getRepository()->getModel();
        $authorization->code    = uniqid();
        $authorization->user_id = $userId;
        $authorization->save();

        $client = new Client(['base_uri' => env('AUTHORIZATION_APP_URL')]);

        $encryptToSend = Helper::encryptDifferentiated(json_encode([
                'user_id' => $userId,
                'authorization_code' => $authorization->code,
                'app_own_id' => $owdId,
                'slug' => $slug
                ]), env('AUTHORIZATION_PUBLIC_KEY'));

        $response = $client->post('?action=generateTempToken',
            [
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
            'sessionId' => Helper::generateUniqueSessionIdentifier($owdId,
                $slug, $userId)
        ]);

        return [
            'params' => $params,
            'status' => true
        ];
    }

    public function generateTempAuthInSourcer()
    {
        $session = SessionService::getCurrentData();

        $client = new Client([
            'headers' => ['Authorization' => $session['token']]
        ]);

        $response          = $client->post($session['own_api_url'].'/login/generateTempAuthByToken');
        $extractedResponse = Helper::extractJsonFromRequester($response);

        if ($extractedResponse['status'] === false) {
            throw new ImpossibilityGenerateTokenByTokenException($extractedResponse['response']['message']);
        }

        return $extractedResponse;
    }

    public function getTempAuthByState(array $state)
    {
        if (empty($state) || !isset($state['user_id']) || !isset($state['slug'])) {
            throw new \DomainException();
        }

        $service = new UserService();
        if (empty($user = $service->find($state['user_id']))) {
            throw new NotFoundInDatabaseException();
        }

        return $this->getTempAuth($user, $state['slug']);
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