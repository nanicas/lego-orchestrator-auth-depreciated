<?php

namespace Zevitagem\LegoAuth\Helpers;

use Psr\Http\Message\ResponseInterface;
use Zevitagem\LegoAuth\Adapters\FactoryAdapter;
use Zevitagem\LegoAuth\Controllers\AuthorizationController;
use Zevitagem\LegoAuth\Controllers\ApplicationController;

class Helper
{
    public static function createBuildQueryToOutLogin(): string
    {
        $adapter = self::getGeneralAdapter();
        $args    = func_get_args();

        return http_build_query(array_merge([
            'url_callback' => $adapter->getLoginRoute(),
            'app_requester_id' => self::getAppId()
        ], ...$args));
    }

    public static function getSessionData()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::getCurrentData();
    }

    public static function getToken()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::getCurrentData()['token'];
    }

    public static function getSlug()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::getCurrentData()['slug']['id'];
    }

    public static function getUserId()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::getCurrentData()['user']['id'];
    }

    public static function getUserConfig()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::getCurrentData()['user']['config'];
    }

    public static function getCustomer()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::getCurrentData()['customer'];
    }

    public static function getContract()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::getCurrentData()['contract'];
    }

    public static function isMaster()
    {
        $customer = self::getCustomer();
        return (!empty($customer) && !empty($customer['active']));
    }

    public static function isAdmin()
    {
        $userConfig = self::getUserConfig();
        if (empty($userConfig)) {
            return false;
        }

        return (!empty($userConfig['admin']));
    }

    public static function isLaravel()
    {
        $config = self::readConfig();

        return (!empty($config['is_laravel']));
    }

    public static function hasPage(string $page): bool
    {
        $config = self::readConfig();

        return (isset($config['pages'][$page]) && $config['pages'][$page] === true);
    }

    public static function getPackage()
    {
        $config = self::readConfig();

        return $config['package'] ?? 'anc';
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

    public static function generateUniqueSessionIdentifier(
        int $appId, int $slug, int $userId
    )
    {
        return hash("crc32", "$appId-$slug-$userId}");
    }

    public static function isLogged()
    {
        return \Zevitagem\LegoAuth\Services\SessionService::isLogged();
    }

    public static function startSession()
    {
        self::getSessionAdapter()->startSession();
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
        //$prefix = (isset($_SERVER["PWD"])) ? $_SERVER["PWD"] : '..';
	$prefix = '..';
        $file = $prefix.'/lego_config.php';

        if (file_exists($file)) {
            return require $file;
        }

        return [];
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

    public static function defineLaravelWebMiddlewares(array $middlewares = ['web'])
    {
        return self::defineWebMiddlewares($middlewares);
    }

    public static function defineWebMiddlewares(array $middlewares = [])
    {
        if (empty($config = self::readConfig())) {
            return $middlewares;
        }

        if ($config['is_sourcer'] == false) {
            $middlewares[] = $config['middlewares']['auth_filler_middleware'];
        }

        return $middlewares;
    }

    public static function loadLaravelLegoRoutes(array $config, array $classes)
    {
        if (!isset($classes['login_controller'])) {
            throw new \InvalidArgumentException('The attribute "login_controller" was not informed for loading routes');
        }

        if (empty($config)) {
            return;
        }

        \Route::prefix($config['package'])->group(
            function () use ($config, $classes) {

            \Route::prefix($config['api_group'])
                ->middleware([$config['middlewares']['authenticable_middleware']])
                ->group(function () use ($config, $classes) {

                    \Route::post('/login/generateTempAuthByToken',
                        [$classes['login_controller'], 'generateTempAuthByToken'])->name('generateTempAuthByToken');

                    \Route::prefix('/users')->group(function () use ($config) {
                        \Route::get('/{id}', [$config['user_api'], 'find']);
                    });

                    \Route::prefix('/config_users')->group(function () use ($config) {
                        \Route::get('/{userId}/{slug}',
                            [$config['config_user_api'], 'getByUserAndSlug']);
                    });
                });

            \Route::prefix('/login')->middleware(['web'])->group(function () use ($classes) {

                \Route::post('/generateTempAuthInSourcer',
                    [$classes['login_controller'], 'generateTempAuthInSourcer'])->name('generateTempAuthInSourcer');

                \Route::get('/generateTokenByTemp',
                    [$classes['login_controller'], 'generateTokenByTemp'])->name('generateTokenByTemp');

                \Route::get('/tryRegenerateToken',
                    [$classes['login_controller'], 'tryRegenerateToken'])->name('tryRegenerateToken');

                \Route::get('/changeSessionByIdentifier',
                    [$classes['login_controller'], 'changeSessionByIdentifier'])->name('changeSessionByIdentifier');
            });

            \Route::post('/authorization/verify',
                [AuthorizationController::class, 'verify']);
            \Route::get('/application/{app}/slugs',
                [ApplicationController::class, 'slugs'])->name('slugs');
            \Route::get('/application/buildOutLoginRoute',
                [ApplicationController::class, 'buildOutLoginRoute'])->name('build_out_login_route');
        });
    }

    public static function hydrateUnique(string $class, array $data)
    {
        return $class::hydrate([$data])->first();
    }
}
