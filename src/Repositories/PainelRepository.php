<?php

namespace Zevitagem\LegoAuth\Repositories;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Repositories\AbstractRepository;

class PainelRepository extends AbstractRepository
{
    const ROUTE = 'painel';

    public function getInfoBySlugTextAndApplication(
        string $slug, int $applicatonId
    )
    {
        $url    = env('PAINEL_APP_URL');
        $params = http_build_query(array_merge([
            'application_id' => $applicatonId,
            'slug' => $slug,
            'action' => 'getContractBySlugTextAndApplication'
        ]));

        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'route' => self::ROUTE
            ]
        ]);

        $response = $client->request('GET', '?'.$params);

        $data = Helper::extractJsonFromRequester($response);

        if ($data['status'] == false) {
            return null;
        }

        return $data['response'];
    }
}