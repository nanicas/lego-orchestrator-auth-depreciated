<?php

namespace App\Libraries\Annacode\Services;

use GuzzleHttp\Client;
use App\Libraries\Annacode\Hydrators\ApplicationHydrator;
use App\Libraries\Annacode\Helpers\Helper;

class ApplicationService
{

    public function getAllowedApplicationsToLogin()
    {
        $hydrator = new ApplicationHydrator();

        $client   = new Client(['base_uri' => env('AUTHORIZATION_APP_URL').'?action=getApplications&type=f']);
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        return $hydrator->hydrateArray($extractedResponse['response']);
    }
}