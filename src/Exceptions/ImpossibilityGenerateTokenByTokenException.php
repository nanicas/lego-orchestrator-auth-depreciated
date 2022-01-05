<?php

namespace Zevitagem\LegoAuth\Exceptions;

use Zevitagem\LegoAuth\Exceptions\ExceptionComplementalMessage;

class ImpossibilityGenerateTokenByTokenException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi possível gerar um token novo';

}