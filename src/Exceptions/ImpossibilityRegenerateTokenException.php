<?php

namespace Zevitagem\LegoAuth\Exceptions;

use Zevitagem\LegoAuth\Exceptions\ExceptionComplementalMessage;

class ImpossibilityRegenerateTokenException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi possível regerar um token novo';

}