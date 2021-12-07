<?php

namespace App\Libraries\Annacode\Exceptions;

use App\Libraries\Annacode\Exceptions\ExceptionComplementalMessage;

class ImpossibilityRegenerateTokenException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi possível regerar um token novo';

}