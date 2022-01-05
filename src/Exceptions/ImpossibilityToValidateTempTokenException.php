<?php

namespace Zevitagem\LegoAuth\Exceptions;

use Zevitagem\LegoAuth\Exceptions\ExceptionComplementalMessage;

class ImpossibilityToValidateTempTokenException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi possível validar o código de acesso temporário';

}