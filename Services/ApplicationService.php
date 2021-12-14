<?php

namespace App\Libraries\Annacode\Services;

use GuzzleHttp\Client;
use App\Libraries\Annacode\Hydrators\ApplicationHydrator;
use App\Libraries\Annacode\Helpers\Helper;
use App\Libraries\Annacode\Contracts\FilterContract;

class ApplicationService
{
    private $filter = [];

    public function __construct(FilterContract $filter)
    {
        $this->filter = $filter;
    }

    private function getApplications(string $type)
    {
        $hydrator = new ApplicationHydrator();

        $client   = new Client(['base_uri' => env('AUTHORIZATION_APP_URL').'?action=getApplications&type='.$type]);
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        $applications = $hydrator->hydrateArray($extractedResponse['response']);

        if (empty($applications)) {
            return;
        }

        return $this->filter->filter($applications);
    }

    public function getAllowedApplicationsToLogin()
    {
        return $this->getApplications('o');
    }

    public function getApplicationsToShareSession()
    {
        return $this->getApplications('f');
    }
}