<?php

namespace Zevitagem\LegoAuth\Contracts;

interface PersistenceDataContract
{

    public static function getAdapter();

    public static function getIdentifier();
}