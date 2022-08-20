<?php

namespace Zevitagem\LegoAuth\Traits;

use Zevitagem\LegoAuth\Exceptions\CurrentAuthNotFoundException;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityRegenerateTokenException;
use Zevitagem\LegoAuth\Exceptions\ImpossibilityToValidateTempTokenException;
use Zevitagem\LegoAuth\Services\SessionService;
use Zevitagem\LegoAuth\Helpers\Helper;

trait NavigateAsAppController
{

    public function changeSessionByIdentifier()
    {
        Helper::getSessionAdapter()->startSession();

        $id = $_GET['id'];
        
        try {
            SessionService::isLoggedByIdentifier($id);
            $this->getService()->changeSessionByIdentifier($id);
        } catch (\Throwable $exc) {
            Helper::getGeneralAdapter()->setFlash('error_message', $exc->getMessage());
        } finally {
            return Helper::getLoginAdapter()->redirSuccessfully();
        }
    }

    public function tryRegenerateToken()
    {
        Helper::getSessionAdapter()->startSession();

        $attempt = SessionService::getCurrentAttempt();
        if (SessionService::reachedMaxLoginAttempt($attempt)) {
            SessionService::resetLoginAttempts();
            return Helper::getLoginAdapter()->redirLoginPage(['message' => $_GET['message']]);
        }

        try {
            $service = $this->getService();
            try {
                SessionService::isLogged(); //otherwise, throws exception
            } catch (\Throwable $thr) {

                $service->tryRegenerateAccessToken();

                $sessionData = $service->generateSessionData($service->getResponse()['response']);
                $service->configureSession($sessionData);

                SessionService::resetLoginAttempts();
            }

            return Helper::getLoginAdapter()->redirSuccessfully();
        } catch (CurrentAuthNotFoundException | ImpossibilityRegenerateTokenException $exception) {
            return Helper::getLoginAdapter()->redirLoginPage(['message' => $exception->getMessage()]);
        } catch (\Throwable $thr) {
            return Helper::getLoginAdapter()->redirLoginPage(['message' => $thr->getMessage()]);
        } finally {
            SessionService::incrementLoginAttempt();
        }
    }

    public function generateTokenByTemp()
    {
        Helper::getSessionAdapter()->startSession();
        
        try {
            try {
                SessionService::isLoggedByIdentifier($_GET['sessionId'] ?? '');
            } catch (\Throwable $thr) {
                $service = $this->getService();
                $service->tryGenerateAccessToken($_GET);

                $sessionData = $service->generateSessionData($service->getResponse()['response']);
                $service->configureSession($sessionData['mandatory']);

                if (Helper::isLaravel() 
                    && Helper::hasPage('user_config')
                    && $sessionData['optional']['config'] === null) {
                    return Helper::getLoginAdapter()->redirUserConfigPage();
                }
            }

            return Helper::getLoginAdapter()->redirSuccessfully();
        } catch (ImpossibilityToValidateTempTokenException $exception) {
            return Helper::getLoginAdapter()->redirLoginPage(['message' => $exception->getMessage()]);
        } catch (\Throwable $thr) {
            return Helper::getLoginAdapter()->redirLoginPage(['message' => $thr->getMessage()]);
        }
    }
}