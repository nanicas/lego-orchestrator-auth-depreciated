<?php

namespace App\Libraries\Annacode\Services;

use App\Libraries\Annacode\Traits\NavigateAsAppService;
use App\Libraries\Annacode\Services\AbstractLoginService;
use App\Libraries\Annacode\Services\SessionService;
use GuzzleHttp\Client;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Exceptions\ImpossibilityGenerateTokenByTokenException;

class LoginNotSourceService extends AbstractLoginService
{

    use NavigateAsAppService;

    public function generateTempAuthInSourcer()
    {
        $session = SessionService::getCurrentSessionData();

        $client = new Client([
            'headers' => ['Authorization' => $session['token']]
        ]);

        $response = $client->post($session['own_url']. '/login/generateTempAuthByToken');
        $extractedResponse = Helper::extractJsonFromRequester($response);

        if ($extractedResponse['status'] === false) {
            throw new ImpossibilityGenerateTokenByTokenException($extractedResponse['response']['message']);
        }

        return $extractedResponse;
    }
}