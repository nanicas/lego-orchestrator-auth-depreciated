<?php

namespace Zevitagem\LegoAuth\Services;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Hydrators\ApplicationHydrator;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Contracts\FilterContract;

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