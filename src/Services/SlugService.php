<?php

namespace Zevitagem\LegoAuth\Services;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;

class SlugService
{
    public function getSlugsByApplication(int $app)
    {
        $client = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL') . '?action=getSlugsByApp&app=' . $app,
            'headers' => [
                'route' => 'access'
            ]
        ]);
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        return Helper::hydrateByModel('slug', $extractedResponse['response']);
    }

    public function getActivesSlugsByApplication(int $app)
    {
        $client = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL') . '?action=getActivesSlugsByApplication&app=' . $app,
            'headers' => [
                'route' => 'access'
            ]
        ]);
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        return Helper::hydrateByModel('contract', $extractedResponse['response']);
    }

    public function getSlug(int $slug)
    {
        $client = new Client([
            'base_uri' => env('AUTHORIZATION_APP_URL') . '?action=getSlug&id=' . $slug,
            'headers' => [
                'route' => 'access'
            ]
        ]);

        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        if (empty($extractedResponse['response'])) {
            return null;
        }

        return Helper::hydrateByModel('slug', $extractedResponse['response']);
    }
}
