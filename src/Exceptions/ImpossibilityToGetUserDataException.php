<?php

namespace Zevitagem\LegoAuth\Exceptions;

use Zevitagem\LegoAuth\Exceptions\ExceptionComplementalMessage;

class ImpossibilityToGetUserDataException extends ExceptionComplementalMessage
{
    const DEFAULT_MESSAGE = 'Não foi buscar os dados do usuário logado corretamente';

}