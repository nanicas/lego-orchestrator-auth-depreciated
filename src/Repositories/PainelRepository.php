<?php

namespace Zevitagem\LegoAuth\Repositories;

use GuzzleHttp\Client;
use Zevitagem\LegoAuth\Helpers\Helper;
use Zevitagem\LegoAuth\Repositories\AbstractRepository;

class PainelRepository extends AbstractRepository
{
    const PAINEL_HANDLER_KEY = 'painel_handler';
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

        $customer = Helper::hydrateByModel('customer', [$data['response']['customer']])->first();
        $slugs    = Helper::hydrateByModel('contract', $data['response']['slugs']);

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

        return Helper::hydrateByModel('contract', [$data['response']])->first();
    }

    public function getSegments()
    {
        $url    = env('PAINEL_APP_URL');
        $params = http_build_query(array_merge([
            'action' => 'getSegments'
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

        return Helper::hydrateByModel('segment', $data['response']);
    }
    
    public function getRulesByApplication(int $appId)
    {
        $url    = env('PAINEL_APP_URL');
        $params = http_build_query(array_merge([
            'action' => 'getRulesByApp',
            'application_id' => $appId
        ]));

        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'route' => self::ROUTE
            ]
        ]);

        $response = $client->request('GET', '?'.$params);

        $data = Helper::extractJsonFromRequester($response);
        $rules = [];

        if (!empty($data['response'])) {
            $rules = Helper::hydrateByModel('rule', $data['response']);
        }

        $this->handle(self::PAINEL_HANDLER_KEY, 'after', __FUNCTION__, $rules);
        return $rules;
    }

    public function getScopesByRule($ruleId = null)
    {
        if (empty($ruleId)) {
            return [];
        }

        $url    = env('PAINEL_APP_URL');
        $params = http_build_query(array_merge([
            'action' => 'getScopesByRule',
            'rule_id' => $ruleId
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

        return Helper::hydrateByModel('scope', $data['response']);
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

        return Helper::hydrateByModel('contract', $data['response']['contracts']);
    }
}