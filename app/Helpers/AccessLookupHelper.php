<?php

namespace App\Helpers;

class AccessLookupHelper {

    public static function isInternalAccess()
    {
        $internal_gateway = config('dashboard.internal_gateway');

        if ($internal_gateway == 'localhost' || $internal_gateway == '127.0.0.1')
            $internal_gateway = '::1';

        return $_SERVER['SERVER_ADDR'] == $internal_gateway;
    }

}
