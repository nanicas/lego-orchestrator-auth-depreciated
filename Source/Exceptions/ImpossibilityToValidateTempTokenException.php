<?php

namespace App\Libraries\Annacode\Exceptions;

use App\Libraries\Annacode\Exceptions\ExceptionComplementalMessage;

class ImpossibilityToValidateTempTokenException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi possível validar o código de acesso temporário';

}