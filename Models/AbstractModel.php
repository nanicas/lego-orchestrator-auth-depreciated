<?php

namespace App\Libraries\Annacode\Models;

use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{

//    public function hydrate(array $attributes)
//    {
//        foreach ($attributes as $attr => $value) {
//            $this->{$attr} = $value;
//        }
//    }

    public static function getPrimaryKey()
    {
        return static::PRIMARY_KEY;
    }

    public function getPrimaryValue()
    {
        return $this->{self::getPrimaryKey()};
    }
}
