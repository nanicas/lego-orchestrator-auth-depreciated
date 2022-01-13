<?php

namespace Zevitagem\LegoAuth\Traits;

use Zevitagem\LegoAuth\Services\Login\LoginConfig;
use Zevitagem\LegoAuth\Exceptions\CurrentAuthNotFoundException;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityRegenerateTokenException;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityToValidateTempTokenException;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityToGetUserDataException;
use Zevitagem\LegoAuth\Services\SessionService;
use Zevitagem\LegoAuth\Traits\ResponseTrait;
use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Factories\PersistenceDataFactory;

trait NavigateAsAppService
{

    use ResponseTrait;

    private $config;
    private $user;
    private $userService;
    private $continuousStorage;
    private $tempStorage;

    public function __construct()
    {
        $this->config = new LoginConfig();
        $this->continuousStorage = PersistenceDataFactory::continuous();
        $this->tempStorage = PersistenceDataFactory::temp();
    }

    public function tryGenerateAccessToken(array $data)
    {
        $client          = new Client(['base_uri' => $this->config->getUrl()]);
        $requestResponse = $client->request('GET', '',
            ['query' => [
                    'token' => $data['token'],
                    'action' => 'generateTokenByTemp']
        ]);

        $response = Helper::extractJsonFromRequester($requestResponse);
        $this->setResponse($response);

        if ($response['status'] == false) {
            throw new ImpossibilityToValidateTempTokenException($response['response']['message']);
        }

        return true;
    }

    public function tryRegenerateAccessToken()
    {
        $id = $this->continuousStorage->getIdentifier();

        $refreshTokenEncrypted = $this->continuousStorage->getRefreshTokenByIdentifier($id);
        if (empty($refreshTokenEncrypted)) {
            throw new CurrentAuthNotFoundException('Não foi possível encontrar os dados mínimos para gerar um novo acesso');
        }

        $refreshToken          = Helper::decryptDifferentiated($refreshTokenEncrypted,
                env('PRIVATE_KEY'));
        $refreshTokenEncrypted = Helper::encryptDifferentiated($refreshToken,
                env('AUTHORIZATION_PUBLIC_KEY'));

        $client          = new Client(['base_uri' => $this->config->getUrl()]);
        $requestResponse = $client->request('POST', '?action=generateTokenByRefresh',
            [
                'form_params' => [
                    'refresh_access' => $refreshTokenEncrypted
                ]
        ]);

        $response = Helper::extractJsonFromRequester($requestResponse);
        $this->setResponse($response);

        if ($response['status'] == false) {
            throw new ImpossibilityRegenerateTokenException($response['response']['message']);
        }

        return true;
    }

    public function generateSessionData(array $data)
    {
        $client          = new Client(['headers' => ['Authorization' => $data['token']]]);
        $requestResponse = $client->request('GET', $data['own_internal_api_url'].'/users/'.$data['user_id']);
        
        $response = Helper::extractJsonFromRequester($requestResponse);
        $this->setResponse($response);

        if ($response['status'] == false) {
            throw new ImpossibilityToGetUserDataException($response['response']['message']);
        }

        $data['user'] = $response['response'];
        return $data;
    }

    public function changeSessionByIdentifier(string $identifier)
    { 
        $tempStorageAdapter = $this->tempStorage::getAdapter();
        $tempStorageAdapter->changeTempSessionDataByIdentifier([
            'session_identifier' => $identifier
        ]);

        $auth = SessionService::getAdapter()->readSessionValue('auth');

        $continuousStorageAdapter = $this->continuousStorage::getAdapter();
        $continuousStorageAdapter->changeContinuousDataByIdentifier([
            'expire_at' => ($auth[$identifier]['created_at'] + $auth[$identifier]['expire_at']),
            'path' => env('APP_URL'),
            'session_identifier' => $identifier
        ]);
    }

    public function configureSession(array $data)
    {
        $sessionIdentifier = Helper::generateUniqueSessionIdentifier(
                $data['own_id'], $data['slug'], $data['user_id']
        );

        $tempStorageAdapter = $this->tempStorage::getAdapter();
        $tempStorageAdapter->configureTempSessionData([
            'is_logged' => true,
            'session_identifier' => $sessionIdentifier,
            'token' => $data['token'],
            'expire_at' => $data['expire_at'],
            'own_url' => $data['own_url'],
            'own_api_url' => $data['own_api_url'],
            'slug' => $data['slug'],
            'own_id' => $data['own_id'],
            'user' => $data['user'],
            'created_at' => time()
        ]);

        $continuousStorageAdapter = $this->continuousStorage::getAdapter();
        $continuousStorageAdapter->configureContinuousData([
            'session_identifier' => $sessionIdentifier,
            'path' => env('APP_URL'),
            'expire_at' => $data['expire_at'],
            'refresh_token' => Helper::encryptDifferentiated(
                $data['refresh_token'], env('PUBLIC_KEY')
            ),
        ]);
    }

}