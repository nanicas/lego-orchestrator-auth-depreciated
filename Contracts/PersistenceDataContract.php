<?php

namespace App\Libraries\Annacode\Contracts;

interface PersistenceDataContract
{

    public static function getAdapter();

    public static function getIdentifier();
}