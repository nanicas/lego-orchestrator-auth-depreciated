<?php

namespace App\Libraries\Annacode\Hydrators;

use App\Libraries\Annacode\Models\Application;

class ApplicationHydrator
{

    public function getModel()
    {
        return Application::class;
    }

    public function hydrateArray(array $list)
    {
        return $this->getModel()::hydrate($list);
    }
}
