<?php

namespace App\Libraries\Annacode\Exceptions;

class NotAuthenticatedException extends \Exception
{

    public function __construct(string $message = 'Nenhuma autenticação encontrada',
                                int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code);
    }
}