<?php

namespace Zevitagem\LegoAuth\Traits;

use Zevitagem\LegoAuth\Services\Login\LoginConfig;
use Zevitagem\LegoAuth\Exceptions\CurrentAuthNotFoundException;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityRegenerateTokenException;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityToValidateTempTokenException;
use Zevitagem\LegoAuth\Services\SessionService;
use Zevitagem\LegoAuth\Traits\ResponseTrait;
use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Factories\PersistenceDataFactory;
use Zevitagem\LegoAuth\UseCase\UserDataCase;

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
        $this->config            = new LoginConfig();
        $this->continuousStorage = PersistenceDataFactory::continuous();
        $this->tempStorage       = PersistenceDataFactory::temp();
    }

    public function tryGenerateAccessToken(array $data)
    {
        $client = new Client([
            'base_uri' => $this->config->getUrl(),
            'headers' => $this->config->getHeaders()
        ]);
        
        $requestResponse = $client->request('GET', '',
            [
                'query' => [
                    'token' => $data['token'],
                    'action' => 'generateTokenByTemp'
                ]
            ]
        );

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

        $refreshToken          = Helper::decryptDifferentiated(
            $refreshTokenEncrypted,
            env('PRIVATE_KEY')
        );
        
        $refreshTokenEncrypted = Helper::encryptDifferentiated(
            $refreshToken,
            env('AUTHORIZATION_PUBLIC_KEY')
        );

        $client = new Client([
            'base_uri' => $this->config->getUrl(),
            'headers' => $this->config->getHeaders()
        ]);
        
        $requestResponse = $client->request('POST', '?action=generateTokenByRefresh',
            [
                'form_params' => [
                    'refresh_access' => $refreshTokenEncrypted
                ]
            ]
        );

        $response = Helper::extractJsonFromRequester($requestResponse);
        $this->setResponse($response);

        if ($response['status'] == false) {
            throw new ImpossibilityRegenerateTokenException($response['response']['message']);
        }

        return true;
    }

    public function generateSessionData(array $data)
    {
        $service = new UserDataCase($data);
        
        $data['user'] = $service->getUser();
        $config = $service->getConfigUser();

        return [
            'mandatory' => $data,
            'optional' => [
                'config' => $config
            ]
        ];
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
            $data['authenticator']['id'], $data['slug']['id'], $data['user_id']
        );

        $tempStorageAdapter = $this->tempStorage::getAdapter();
        $tempStorageAdapter->configureTempSessionData([
            'is_logged' => true,
            'session_identifier' => $sessionIdentifier,
            'token' => $data['token'],
            'expire_at' => $data['expire_at'],
            'authenticator' => $data['authenticator'],
            'requester' => $data['requester'],
            'slug' => $data['slug'],
            'user' => $data['user'],
            'segment' => $data['segment'],
            'customer' => $data['customer'],
            'contract' => $data['contract'],
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