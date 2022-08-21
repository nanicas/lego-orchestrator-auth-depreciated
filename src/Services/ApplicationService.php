<?php

namespace Zevitagem\LegoAuth\Services;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Hydrators\ApplicationHydrator;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Contracts\FilterContract;
use Zevitagem\LegoAuth\Filters\ApplicationCompleter;

class ApplicationService
{
    const SOURCER_TYPE = 's';
    const NOT_SOURCER_TYPE = 'ns';
    const APP_TYPE = 'a';
    
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

        $client   = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL').'?action=getApplications&type='.$type,
            'headers' => [
                'route' => 'access'
            ]
        ]);
        
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        $applications = $hydrator->hydrateArray($extractedResponse['response']);

        if (empty($applications)) {
            return;
        }

        return $this->filter->filter($applications);
    }

    public function getApplication(int $app)
    {
        $hydrator = new ApplicationHydrator();

        $client   = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL').'?action=getApplication&id='.$app,
            'headers' => [
                'route' => 'access'
            ]
        ]);
        
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        return $hydrator->hydrate($extractedResponse['response']);
    }
    
    public function getApplicationsByFilters(array $filters = [])
    {
        $params = http_build_query(array_merge($filters, [
            'action' => 'getApplicationsByFilters'
        ]));
        
        $client   = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL').'?action=getApplicationsByFilters',
            'headers' => [
                'route' => 'access'
            ]
        ]);
        
        $response = $client->request('GET', '?'.$params);

        $extractedResponse = Helper::extractJsonFromRequester($response);

        return Helper::hydrateByModel('application', $extractedResponse['response']);
    }
    
    public function getAllowedApplicationsToLogin()
    {
        return $this->getApplications(self::SOURCER_TYPE);
    }

    public function getApplicationsToShareSession()
    {
        return $this->getApplications(self::APP_TYPE);
    }

    public function getApplicationsToEnjoy()
    {
        return $this->getApplications(self::NOT_SOURCER_TYPE);
    }
}