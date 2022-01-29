<?php

namespace Zevitagem\LegoAuth\Services;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Hydrators\ApplicationHydrator;
use Zevitagem\LegoAuth\Hydrators\SlugHydrator;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Contracts\FilterContract;
use Zevitagem\LegoAuth\Filters\ApplicationCompleter;

class ApplicationService
{
    private $filter = [];

    public function __construct()
    {
        $this->setFilter(new ApplicationCompleter());
    }

    public function setFilter(FilterContract $filter)
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

    public function getSlugsByApplication(int $app)
    {
        $hydrator = new SlugHydrator();

        $client   = new Client(['base_uri' => env('AUTHORIZATION_APP_URL').'?action=getSlugsByApp&app='.$app]);
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        return $hydrator->hydrateArray($extractedResponse['response']);
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