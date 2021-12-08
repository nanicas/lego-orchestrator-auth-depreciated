<?php

namespace App\Libraries\Annacode\Services;

use GuzzleHttp\Client;
use App\Libraries\Annacode\Hydrators\ApplicationHydrator;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientService
 *
 * @author Joseph
 */
class ApplicationService
{

    public function getAllowedApplicationsToLogin()
    {
        $hydrator = new ApplicationHydrator();

        $client   = new Client(['base_uri' => config('app.wrapper_app').'/applications']);
        $response = $client->request('GET');

        return $hydrator->hydrateArray(json_decode($response->getBody()->getContents()));
    }

}