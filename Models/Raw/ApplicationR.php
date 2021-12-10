<?php

namespace App\Libraries\Annacode\Models\Raw;

use App\Libraries\Annacode\Models\AbstractRawModel;
use App\Libraries\Annacode\Traits\Models\ApplicationModelTrait;

class ApplicationR extends AbstractRawModel
{

    use ApplicationModelTrait;

    const TABLE = 'applications';
}