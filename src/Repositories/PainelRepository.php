<?php

namespace Zevitagem\LegoAuth\Repositories;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Repositories\AbstractRepository;
use Zevitagem\LegoAuth\Hydrators\ContractHydrator;

class PainelRepository extends AbstractRepository
{
    const ROUTE = 'painel';

    public function getContractBySlugTextAndApplication(
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

        if ($data['status'] == false || empty($data['response']['contract'])) {
            return null;
        }

        $hydrator = new ContractHydrator();

        return $hydrator->hydrate($data['response']['contract']);
    }
}