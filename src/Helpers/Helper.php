<?php

namespace Zevitagem\LegoAuth\Helpers;

use Psr\Http\Message\ResponseInterface;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;

class Helper
{

    public static function createBuildQueryToOutLogin(): string
    {
        $adapter = self::getGeneralAdapter();

        return http_build_query([
            'url_callback' => $adapter->getLoginRoute()
        ]);
    }

    public static function getAppId()
    {
        return env('APP_ID');
    }

    public static function extractJsonFromRequester(ResponseInterface $requester)
    {
        $content = $requester->getBody()->getContents();
        $json    = json_decode($content, true);

        return $json ?? self::createDefaultJsonToResponse(false,
                ['message' => $content]);
    }

    public static function createDefaultJsonToResponse(bool $status,
                                                       $content = null)
    {
        return ['response' => $content, 'status' => $status];
    }

    public static function decryptDifferentiated($data, $privateKey)
    {
        openssl_private_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }

    public static function encryptDifferentiated($data, $publicKey)
    {
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return $encrypted;
    }

    public static function generateUniqueSessionIdentifier(int $ownId,
                                                           string $slug,
                                                           int $userId)
    {
        return hash("crc32", "$ownId-$slug-$userId}");
    }

    public static function isLogged()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::isLogged();
    }

    public static function sessionStart()
    {
        self::getSessionAdapter()->sessionStart();
    }

    public static function throwEvent(string $method, array $args)
    {
        $config = self::readConfig();

        if (!isset($config['event_class'])) {
            return;
        }

        $event = new $config['event_class']();

        if (!method_exists($event, $method)) {
            return;
        }

        $event->{$method}($args);
    }

    public static function readConfig()
    {
        $prefix = (isset($_SERVER["PWD"])) ? $_SERVER["PWD"] : '..';

        return require $prefix.'/annacode_config.php';
    }

    public static function getAdapter(string $type)
    {
        return FactoryAdapter::instance($type);
    }

    public static function getLoginAdapter()
    {
        return self::getAdapter(FactoryAdapter::LOGIN_TYPE);
    }

    public static function getGeneralAdapter()
    {
        return self::getAdapter(FactoryAdapter::GENERAL_TYPE);
    }

    public static function getSessionAdapter()
    {
        return self::getAdapter(FactoryAdapter::SESSION_TYPE);
    }

    public static function defaultExecutationToReplyJson(\Closure $callable)
    {
        try {
            $data     = $callable();
            $status   = true;
            $response = $data;
        } catch (\Throwable $ex) {
            $message  = $ex->getMessage();
            $status   = false;
            $response = ['message' => $message];
        }

        header('Content-Type: application/json');
        echo json_encode(self::createDefaultJsonToResponse($status, $response));
    }

    public static function isOutSourcedAccess()
    {
        return (!empty($_POST['url_callback']) || !empty($_GET['url_callback']));
    }

    public static function existsTempAuthInUrl()
    {
        return (!empty($_GET['token']));
    }

    public static function laravelWebMiddlewares(array $middlewares = ['web'])
    {
        $config = self::readConfig();

        if ($config['is_sourcer'] == false ) {
            $middlewares[] = $config['middlewares']['auth_filler_middleware'];
        }

        return $middlewares;
    }
}