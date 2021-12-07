<?php

namespace App\Libraries\Annacode\Exceptions;

use App\Libraries\Annacode\Exceptions\ExceptionComplementalMessage;

class ImpossibilityToGetUserDataException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi buscar os dados do usuário logado corretamente';

}