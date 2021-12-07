<?php

namespace App\Libraries\Annacode\Helpers;

use Psr\Http\Message\ResponseInterface;

class Helper
{

    public static function createBuildQueryToOutLogin(): string
    {
        //$complement = () ? : ;
        //$complement = '/routes/login.php';
        $complement = '/public/login/generateTokenByTemp';

        return http_build_query([
            'url_callback' => env('APP_URL').$complement
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
        return \App\Libraries\Annacode\Services\SessionService::isLogged();
    }

    public static function sessionStart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
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
        return \App\Libraries\Annacode\Adapters\FactoryAdapter::instance($type);
    }
}