<?php

namespace App\Libraries\Annacode\Hydrators;

use App\Libraries\Annacode\Helpers\Helper;

class ApplicationHydrator
{

    public function getModel()
    {
        $model = Helper::readConfig()['models']['application'];
        return new $model();
    }

    public function hydrateArray(array $data)
    {
        return $this->getModel()->hydrate($data);
    }
}