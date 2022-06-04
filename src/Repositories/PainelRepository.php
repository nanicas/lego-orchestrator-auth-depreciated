<?php

namespace Zevitagem\LegoAuth\Repositories;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Repositories\AbstractRepository;
use Zevitagem\LegoAuth\Models\Laravel\ContractL;
use Zevitagem\LegoAuth\Models\Laravel\CustomerL;

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

     public function getCustomerInfo(int $id)
    {
        $url    = env('PAINEL_APP_URL');
        $params = http_build_query(array_merge([
            'user_id' => $id,
            'action' => 'getCustomerInfo'
        ]));

        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'route' => self::ROUTE
            ]
        ]);

        $response = $client->request('GET', '?'.$params);

        $data = Helper::extractJsonFromRequester($response);

        if (empty($data['response'])) {
            return [];
        }

        $customer = CustomerL::hydrate([$data['response']['customer']])->first();
        $slugs    = ContractL::hydrate($data['response']['slugs']);

        return compact('customer', 'slugs');
    }

    public function getContract(int $id)
    {
        $url    = env('PAINEL_APP_URL');
        $params = http_build_query(array_merge([
            'id' => $id,
            'action' => 'getContract'
        ]));

        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'route' => self::ROUTE
            ]
        ]);

        $response = $client->request('GET', '?'.$params);

        $data = Helper::extractJsonFromRequester($response);

        if (empty($data['response'])) {
            return [];
        }

        return ContractL::hydrate([$data['response']])->first();
    }

    public function storeContract(array $data)
    {
        $url    = env('PAINEL_APP_URL');

        $client = new Client([
            'base_uri' => $url.'?action=storeContract',
            'form_params' => $data,
            'headers' => [
                'route' => self::ROUTE
            ]
        ]);

        $response = $client->request('POST');

        return Helper::extractJsonFromRequester($response);
    }

    public function updateContract(array $data)
    {
        $url    = env('PAINEL_APP_URL');

        $client = new Client([
            'base_uri' => $url.'?action=updateContract',
            'form_params' => $data,
            'headers' => [
                'route' => self::ROUTE
            ]
        ]);

        $response = $client->request('POST');

        return Helper::extractJsonFromRequester($response);
    }

    public function getContractsByUserAndApplication(
        int $userId, int $applicatonId
    )
    {
        $url    = env('PAINEL_APP_URL');
        $params = http_build_query(array_merge([
            'application_id' => $applicatonId,
            'user_id' => $userId,
            'action' => 'getContractsByUserAndApplication'
        ]));

        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'route' => self::ROUTE
            ]
        ]);

        $response = $client->request('GET', '?'.$params);

        $data = Helper::extractJsonFromRequester($response);

        if (empty($data['response'])) {
            return [];
        }

        return ContractL::hydrate($data['response']['contracts']);
    }
}