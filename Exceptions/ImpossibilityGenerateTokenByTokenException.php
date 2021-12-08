<?php

namespace App\Libraries\Annacode\Exceptions;

use App\Libraries\Annacode\Exceptions\ExceptionComplementalMessage;

class ImpossibilityGenerateTokenByTokenException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi possível gerar um token novo';

}