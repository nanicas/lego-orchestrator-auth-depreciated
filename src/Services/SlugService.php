<?php

namespace Zevitagem\LegoAuth\Services;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Hydrators\SlugHydrator;
use Zevitagem\LegoAuth\Helpers\Helper;

class SlugService
{

    public function getSlugsByApplication(int $app)
    {
        $hydrator = new SlugHydrator();

        $client   = new Client(['base_uri' => env('AUTHORIZATION_APP_URL').'?action=getSlugsByApp&app='.$app]);
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        return $hydrator->hydrateArray($extractedResponse['response']);
    }

    public function getSlug(int $slug)
    {
        $hydrator = new SlugHydrator();

        $client   = new Client(['base_uri' => env('AUTHORIZATION_APP_URL').'?action=getSlug&id='.$slug]);
        $response = $client->request('GET');

        $extractedResponse = Helper::extractJsonFromRequester($response);

        if (empty($extractedResponse['response'])) {
            return null;
        }

        return $hydrator->hydrate($extractedResponse['response']);
    }
}