<?php

namespace App\Libraries\Annacode\Exceptions;

class ExceptionComplementalMessage extends \Exception
{

    public function __construct(string $message = '')
    {
        if ($message != static::DEFAULT_MESSAGE) {
            $message = static::DEFAULT_MESSAGE.' [because] '.$message;
        }

        parent::__construct($message);
    }
}