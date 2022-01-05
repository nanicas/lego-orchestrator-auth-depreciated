<?php

namespace Zevitagem\LegoAuth\Exceptions;

class ExpiredSessionException extends \Exception
{
    public function __construct(string $message = 'Sessão expirada',
                                int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code);
    }
}
