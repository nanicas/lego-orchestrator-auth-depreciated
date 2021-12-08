<?php

namespace App\Libraries\Annacode\Traits;

use App\Libraries\Annacode\Exceptions\CurrentAuthNotFoundException;
use App\Libraries\Annacode\Exceptions\ImpossibilityRegenerateTokenException;
use App\Libraries\Annacode\Services\SessionService;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Adapters\FactoryAdapter;
use Illuminate\Support\Facades\Cookie;

trait NavigateAsAppController
{

    public function getAdapter()
    {
        return Helper::getAdapter(FactoryAdapter::LOGIN_TYPE);
    }

    public function changeSessionByIdentifier()
    {
        Helper::sessionStart();

        $id = $_GET['id'];

        try {
            SessionService::isLoggedByIdentifier($id); //otherwise, throws exception
            $this->getService()->changeSessionByIdentifier($id);
        } catch (\Throwable $exc) {
            $this->getAdapter()->setFlash('error_message', $exc->getMessage());
        } finally {
            return $this->getAdapter()->redirSuccessfully();
        }
    }

    public function tryRegenerateToken()
    {
        Helper::sessionStart();

        $attempt = SessionService::getCurrentAttempt();
        if (SessionService::reachedMaxLoginAttempt($attempt)) {
            SessionService::resetLoginAttempts();
            return $this->getAdapter()->loadView('blocked', ['message' => $_GET['message']]);
        }

        try {
            $service = $this->getService();
            try {
                SessionService::isLogged(); //otherwise, throws exception
            } catch (\Throwable $exc) {
                
                $service->tryRegenerateAccessToken();

                $sessionData = $service->generateSessionData($service->getResponse()['response']);
                $service->configureSession($sessionData);
                
                SessionService::resetLoginAttempts();
            } finally {
                return $this->getAdapter()->redirSuccessfully();
            }
        } catch (CurrentAuthNotFoundException | ImpossibilityRegenerateTokenException $exception) {
            return $this->getAdapter()->redirect('login',
                ['action' => 'index', 'message' => $exception->getMessage()]
            );
        } catch (\Throwable $exc) {
            return $this->getAdapter()->loadView('blocked', ['message' => $exc->getMessage()]);
        } finally {
            SessionService::incrementLoginAttempt();
        }
    }

    public function generateTokenByTemp()
    {   
        Helper::sessionStart();

        try {
            $service = $this->getService();
            try {
                SessionService::isLoggedByIdentifier($_GET['sessionId'] ?? ''); //otherwise, throws exception
            } catch (\Throwable $exc) {

                $service->tryGenerateAccessToken($_GET);

                $sessionData = $service->generateSessionData($service->getResponse()['response']);

                $service->configureSession($sessionData);
            } finally {
                return $this->getAdapter()->redirSuccessfully();
            }
        } catch (\Throwable $exc) {
            return $this->getAdapter()->loadView('blocked', ['message' => $exc->getMessage()]);
        }
    }
}