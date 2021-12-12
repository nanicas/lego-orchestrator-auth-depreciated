<?php

namespace App\Libraries\Annacode\Traits;

use App\Libraries\Annacode\Exceptions\CurrentAuthNotFoundException;
use App\Libraries\Annacode\Exceptions\ImpossibilityRegenerateTokenException;
use App\Libraries\Annacode\Exceptions\ImpossibilityToValidateTempTokenException;
use App\Libraries\Annacode\Services\SessionService;
use App\Libraries\Annacode\Helpers\Helper;

trait NavigateAsAppController
{

    public function changeSessionByIdentifier()
    {
        Helper::sessionStart();

        $id = $_GET['id'];

        try {
            SessionService::isLoggedByIdentifier($id); //otherwise, throws exception
            $this->getService()->changeSessionByIdentifier($id);
        } catch (\Throwable $exc) {
            Helper::getGeneralAdapter()->setFlash('error_message',
                $exc->getMessage());
        } finally {
            return Helper::getLoginAdapter()->redirSuccessfully();
        }
    }

    public function tryRegenerateToken()
    {
        Helper::sessionStart();

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
        Helper::sessionStart();

        try {
            try {
                SessionService::isLoggedByIdentifier($_GET['sessionId'] ?? '');
            } catch (\Throwable $thr) {
                $service = $this->getService();
                $service->tryGenerateAccessToken($_GET);

                $sessionData = $service->generateSessionData($service->getResponse()['response']);
                $service->configureSession($sessionData);
            }

            return Helper::getLoginAdapter()->redirSuccessfully();
        } catch (ImpossibilityToValidateTempTokenException $exception) {
            return Helper::getLoginAdapter()->redirLoginPage(['message' => $exception->getMessage()]);
        } catch (\Throwable $thr) {
            return Helper::getLoginAdapter()->redirLoginPage(['message' => $thr->getMessage()]);
        }
    }
}