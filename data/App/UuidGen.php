<?php

namespace App;

use Ramsey\Uuid\Uuid as RamseyUuid;

class UuidGen
{
    public static function uuid()
    {
        return RamseyUuid::uuid4();
    }

    public static function isValid($id)
    {
        return RamseyUuid::isValid($id);
    }
}
